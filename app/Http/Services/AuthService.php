<?php

namespace App\Http\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthService
{
    public function authenticate(object $request): \Illuminate\Http\JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'error' => true,
                'message' => 'user not found',
            ], 404);
        }

        return response()->json([
            'error' => false,
            'message' => 'Login successful!',
            'user' => new UserResource(auth()->user()),
            'token' => auth()->user()->createToken('user-token')->plainTextToken
        ], 200);
    }


    public function register(object $request)
    {
        try {
            $user = User::create($this->prepareData($request));
        } catch (Throwable $th) {
            Log::alert($th->getMessage());

            return response()->json([
                'error' => true,
                'message' => 'Unable to create new user!'
            ], 500);
        }

        return response()->json([
            'error' => false,
            'message' => 'Login successful!',
            'user' => new UserResource($user),
            'token' => $user->createToken('user-token')->plainTextToken
        ], 200);
    }


    public function getUser()
    {
        return response()->json([
            'error' => false,
            'message' => '',
            'user' => new UserResource(auth()->user())
        ], 200);
    }

    public function logout()
    {
        try {
            auth()->user()->currentAccesToken()->delete();
        } catch (Throwable $th) {
            Log::alert($th->getMessage());

            return response()->json([
                'error' => true,
                'message' => 'Unable to delete user token'
            ], 500);
        }
        return response()->json([
            'error' => false,
            'message' => 'Logout successfully!'
        ], 200);
    }

    public function prepareData(object $request)
    {
        return [
          'name' => $request->name,
          'email' => $request->email,
          'phone' => $request->phone,
            'password' => bcrypt($request->password)
        ];
    }


}
