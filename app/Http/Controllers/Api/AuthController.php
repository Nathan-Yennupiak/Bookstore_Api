<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// use App\Http\Controllers\Api\AuthController;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Basic validation of incoming data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,user',  // Ensure the 'role' field is included and valid
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422); // Return validation errors
        }

        // Create a new User object and save it to the database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password for security
            'role' => $request->role
        ]);

        // Generate an API token for the newly registered user
        return response()->json([
            'message' => 'User registered successfully',
            'token' => $user->createToken('auth-token')->plainTextToken,
            'token type:'=> 'Bearer'
        ], 201); // 201 Created status code
    }

    public function login(Request $request)
    {
        // Validate the email and password provided in the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422); // Return validation errors
        }

        // Find the user by their email address
        $user = User::where('email', $request->email)->first();

        // Check if a user was found and the password matches
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401); // 401 Unauthorized status
        }

        // Create an API token for the user
        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $user->createToken('auth-token')->plainTextToken,
            'token type:'=> 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        // Delete the current access token for the authenticated user
        $request->user()->tokens()->delete();
        return response([
            'message' =>'User logged out succesfully!',
            'note' => 'Token deleted!'
        ], 200);
    }
}

