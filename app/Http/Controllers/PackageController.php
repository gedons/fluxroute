<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Http\Resources\PackageResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return PackageResource::collection(Package::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(3));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageRequest $request)
    {
        $data = $request->validated();

          //Check if image was given and save on local file system
          if (isset($data['image'])) {
                $relativePath  = $this->saveImage($data['image']);
                $data['image'] = $relativePath;
            }

            $shipment = Package::create($data);

            return new PackageResource($shipment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $shipment)
    {
        return new PackageResource($shipment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageRequest $request, Package $shipment)
    {
        $data = $request->validated();

        // Check if image was given and save on local file system
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;

            //If there is an old image, delete it
            if ($shipment->image) {
                $absolutePath = public_path($shipment->image);
                File::delete($absolutePath);
            }
        }

        // Update shipment in the database
        $shipment->update($data);

        return new PackageResource($shipment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $shipment)
    {
        $shipment->delete();

        // If there is an old image, delete it
        if ($shipment->image) {
            $absolutePath = public_path($shipment->image);
            File::delete($absolutePath);
        }

        return response('', 204);
    }

    public function getPackageDetails($trackingNumber)
    {
        $shipment = Package::where('tracking_number', $trackingNumber)->with('user')->first();

        if ($shipment) {
            $shipment->image_url = $shipment->image ? URL::to($shipment->image) : null;
            return response()->json(['shipment' => $shipment]);
        } else {
            return response()->json(['message' => 'Package not found'], 404);
        }
    }   

    private function saveImage($image)
    {
        // Check if image is valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            // Take out the base64 encoded text without mime type
            $image = substr($image, strpos($image, ',') + 1);
            // Get file extension
            $type = strtolower($type[1]); // jpg, png, gif

            // Check if file is an image
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        $dir = 'images/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }
}
