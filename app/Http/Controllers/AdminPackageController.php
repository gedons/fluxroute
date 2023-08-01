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
    public function show(Package $shipment)
    {
       // $users = $package->user->get();

        return new AdminPackagesResource($shipment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $shipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $shipment)
    {
        //
    }
}
