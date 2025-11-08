<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login()
    {
        return response()->json([
            'message' => 'Please login'
        ], 200);
    }

    public function register(RegisterRequest $request): JsonResponse
    {

        $validatedData = $request->validated();

        try {
            $result =  $this->userService->createNewUser($validatedData);
            return response()->json([
                'message' => 'User created successfully',
                'data' => $result
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to create user.',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function authenticate(AuthRequest $request): JsonResponse
    {

        $validatedData = $request->validated();
        try {
            $result = $this->userService->authenticateUser($validatedData);
            return response()->json([
                'message' => 'User logged in successfully',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to login user.',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function logout(Request $request): JsonResponse
    {

        try {
            $this->userService->logoutUser($request->user());
            return response()->json([
                'message' => 'User logged out successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to logout user.',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
