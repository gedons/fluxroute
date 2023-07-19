<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rules\Password;
use Hash;

class AuthController extends Controller
{
    public function CreateAccount(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|confirmed|string|min:6',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'zipcode' => 'required|string|max:20',
            'contact_number' => 'required|string|max:20',
            // 'role' => 'required|string|in:user,driver,admin',
        ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'country' => $request->country,
                'state' => $request->state,
                'address' => $request->address,
                'zipcode' => $request->zipcode,
                'contact_number' => $request->contact_number,
                // 'role' => $request->role,
            ]);

            // Create and assign an API token to the newly registered user
            $token = $user->createToken('main')->plainTextToken;

            return response()->json(['message' => 'User created successfully', 'user' => $user, 'token' => $token], 201);

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',        
        ]);

         // Attempt to authenticate the user based on email and password
         if (Auth::attempt($request->only('email', 'password'))) {
              $user = Auth::user();

              // Generate a new API token for the user
              $token = $user->createToken('main')->plainTextToken;

               // Check the user's role and return the response with the token
                switch ($user->role) {
                    case 'user':
                        return response()->json(['message' => 'User logged in', 'user' => $user, 'token' => $token], 200);
                    case 'driver':
                        return response()->json(['message' => 'Driver logged in', 'user' => $user, 'token' => $token], 200);
                    case 'admin':
                        return response()->json(['message' => 'Admin logged in', 'user' => $user, 'token' => $token], 200);
                    default:
                        return response()->json(['message' => 'Invalid role'], 401);
                }
         }
         return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
