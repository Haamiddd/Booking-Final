<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // Method to fetch all users
    public function getAllUsers()
    {
        $users = User::all(); // Fetch all users from the database
        return response()->json($users, 200); // Return users as a JSON response
    }

    // Method to update a user's details
    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:7|confirmed', // Password is optional
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // Return validation errors if any
        }

        $user = User::findOrFail($id); // Find the user by their ID

        $user->name = $request->name;
        $user->email = $request->email;

        // Update password only if it's provided
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); // Save the updated user details to the database

        return response()->json(['message' => 'User updated successfully!'], 200);
    }

    // Method to delete a user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id); // Find the user by their ID
        $user->delete(); // Delete the user from the database

        return response()->json(['message' => 'User deleted successfully!'], 200);
    }
}
