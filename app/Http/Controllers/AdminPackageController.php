<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Resources\AdminPackagesResource;

class AdminPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allpackages = Package::with('user')
        ->orderBy('created_at', 'DESC')
        ->paginate(6);

        return AdminPackagesResource::collection($allpackages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $product)
    {
        //$users = $product->user->first();

        return new AdminPackagesResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $product)
    {
        //
    }

    public function updateDeliveryStatus(Package $product, Request $request)
    {
         // Update the package status to "pending"
        $product->delivery_status = 'finished';
        $product->save();


        return response()->json(['message' => 'Delivery status updated successfully']);
    }
}
