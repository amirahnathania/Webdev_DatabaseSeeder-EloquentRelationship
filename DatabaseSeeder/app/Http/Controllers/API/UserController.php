<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Get current user profile.
     */
    public function profile()
    {
        try {
            $user = auth()->user();
            
            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'Profil user berhasil diambil'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil profil user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->user();

            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
                'password' => 'sometimes|required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $updateData = [];
            if ($request->has('name')) {
                $updateData['name'] = $request->name;
            }
            if ($request->has('email')) {
                $updateData['email'] = $request->email;
            }
            if ($request->has('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            return response()->json([
                'success' => true,
                'data' => $user->fresh(),
                'message' => 'Profil berhasil diperbarui'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui profil',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all users (Admin only).
     */
    public function index()
    {
        try {
            $users = User::all();
            
            return response()->json([
                'success' => true,
                'data' => $users,
                'message' => 'Daftar user berhasil diambil',
                'count' => $users->count()
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user statistics (Admin only).
     */
    public function statistics()
    {
        try {
            $totalUsers = User::count();
            $adminUsers = User::where('role', 'admin')->count();
            $memberUsers = User::where('role', 'member')->count();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'total_users' => $totalUsers,
                    'admin_users' => $adminUsers,
                    'member_users' => $memberUsers
                ],
                'message' => 'Statistik user berhasil diambil'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}