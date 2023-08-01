<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alluser = User::with('packages')
        ->whereNotIn('role', ['admin', 'driver'])
        ->paginate(6);

        return UserResource::collection($alluser);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $alluser)
    {
        $latest_packages = $alluser->packages->first();

        return new UserResource($alluser, compact('latest_packages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $alluser)
    {
        $alluser->delete();      
        return response('Deleted Successfully', 204);
    }
}
