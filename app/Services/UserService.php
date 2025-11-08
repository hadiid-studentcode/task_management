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
        return $this->userRepository->getAllUser();
    }
    public function getUserById($userId)
    {
        return $this->userRepository->getUserById($userId);
    }
    public function deleteUser($userId)
    {
        return $this->userRepository->deleteUser($userId);
    }

    public function createNewUser(array $data)
    {
        DB::beginTransaction();
        try {

            $user =  $this->userRepository->createUser([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);;
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

        if (!Auth::attempt($credentials)) {
            throw new \Exception('Invalid credentials');
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
    public function logoutUser($user)
    {
        $user->tokens()->delete();

        return true;
    }
    public function updateUser($userId, array $data)
    {
        return $this->userRepository->updateUser($userId, $data);
    }
}
