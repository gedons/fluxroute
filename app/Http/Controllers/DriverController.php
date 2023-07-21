<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\DriverResource;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {        
        return DriverResource::collection(User::where('role', 'driver')->orderBy('created_at', 'DESC')->paginate(3));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
          $data = $request->validated();       

          $driver = User::create($data);

          return new DriverResource($driver);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $driver)
    {
        return new DriverResource($driver);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $driver)
    {
        $data = $request->validated();      

        // Update driver in the database
        $driver->update($data);

        return new DriverResource($driver);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $driver)
    {
        $driver->delete();      
        return response('Deleted Successfully', 204);
    }
}
