<?php

namespace App\Repositories;

use App\Http\Resources\HeadOfFamilyResource;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{

    public function login(array $data)
    {
        if (!Auth::guard('web')->attempt($data)) {
            return response([
                'success'   => false,
                'message'   => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success'   => true,
            'token'     => $token,
            'message'   => 'Login Success'
        ]);
    }

    public function logout()
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        $response = [
            'success'   => true,
            'message'   => 'Logout Success'
        ];

        return response($response, 200);
    }

    public function me()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // load relasi dengan benar
            $user->load('roles.permissions');

            // ambil permissions via roles
            $permissions = $user->roles->flatMap->permissions->pluck('name');

            $role = optional($user->roles->first())->name;

            return response()->json([
                'message'   => 'User data',
                'data'      => [
                    'id'       => $user->id,
                    'name'      => $user->name,
                    'email'     => $user->email,
                    'permission' => $permissions,
                    'role'      => $role,
                    'head_of_family' => $user->headOfFamily
                        ? new HeadOfFamilyResource($user->headOfFamily)
                        : null,
                ],
            ]);
        }

        return response()->json([
            'message'       => 'Your re not logged in',
        ], 401);
    }
}
