<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        // Trim inputs
        $input = [
            'name' => trim($request->input('name')),
            'email' => trim($request->input('email')),
            'password' => trim($request->input('password')),
            'password_confirmation' => trim($request->input('password_confirmation')),
            'nic_no' => $request->input('nic_no') !== null ? trim($request->input('nic_no')) : null,
            'phone_number' => $request->input('phone_number') !== null ? trim($request->input('phone_number')) : null,
        ];

        try {
            // Validate input
            $validated = validator($input, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'nic_no' => 'nullable|string|max:20',
                'phone_number' => 'nullable|string|max:20',
            ])->validate();
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nic_no' => $validated['nic_no'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'active' => true,
        ]);

        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $user
        ], 201);
    }

    /**
     * Toggle the 'active' status of the user.
     */
    public function toggleActive($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        $user->active = !$user->active;
        $user->save();

        return response()->json([
            'message' => 'User status updated successfully.',
            'active' => $user->active,
        ], 200);
    }

    /**
     * Soft delete the user.
     */
    public function softDeleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        if ($user->trashed()) {
            return response()->json([
                'message' => 'User is already deleted.'
            ], 400);
        }

        $user->delete();

        return response()->json([
            'message' => 'User soft deleted successfully.'
        ], 200);
    }

    /**
     * Restore a soft-deleted user.
     */
    public function restoreUser($id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        if (!$user->trashed()) {
            return response()->json([
                'message' => 'User is not deleted.'
            ], 400);
        }

        $user->restore();

        return response()->json([
            'message' => 'User restored successfully.'
        ], 200);
    }
}
