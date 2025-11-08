<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserService
{

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        try {
            $users =  $this->userRepository->getAllUser();
            return $users;
        } catch (\Throwable $th) {
            Log::error('User fetch failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
    public function getUserById($userId)
    {

        try {
            $user = $this->userRepository->getUserById($userId);
            return $user;
        } catch (\Throwable $th) {
            Log::error('User fetch failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
    public function deleteUser($userId)
    {
        try {
            $this->userRepository->deleteUser($userId);
            return true;
        } catch (\Throwable $th) {
            Log::error('User deletion failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }

    public function createNewUser(array $userDetails)
    {
        DB::beginTransaction();
        try {

            $userDetails['password'] = bcrypt($userDetails['password']);
            $user =  $this->userRepository->createUser($userDetails);
            DB::commit();


            $token = $user->createToken('auth_token')->plainTextToken;
            return [
                'user' => $user,
                'token' => $token
            ];
        } catch (\Throwable $th) {

            DB::rollBack();

            Log::error('Registration failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);

            throw $th;
        }
    }

    public function authenticateUser(array $credentials)
    {

        try {

            if (!Auth::attempt($credentials)) {
                throw new \Exception('Invalid credentials');
            }

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token
            ];
        } catch (\Throwable $th) {

            Log::error('Login failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);

            throw $th;
        }
    }
    public function logoutUser($user)
    {
        try {
            $user->tokens()->delete();

            return true;
        } catch (\Throwable $th) {
            Log::error('Logout failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
    public function updateUser($userId, array $userDetails)
    {
        try {
            $user = $this->userRepository->updateUser($userId, $userDetails);
            return $user;
        } catch (\Throwable $th) {
            Log::error('User update failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
}
