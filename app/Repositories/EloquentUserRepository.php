<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class EloquentUserRepository implements UserRepositoryInterface
{

    public function getAllUser()
    {
        return User::all();
    }
    public function getUserById($userId)
    {
        return User::findOrFail($userId);
    }
    public function deleteUser($userId)
    {
        return User::destroy($userId);
    }

    public function createUser(array $userDetails)
    {
        return User::create($userDetails);
    }

    public function updateUser($userId, array $newDataDetails)
    {
        return User::where('id', $userId)->update($newDataDetails);
    }
}
