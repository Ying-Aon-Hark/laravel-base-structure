<?php

namespace App\Contracts\Service;

interface UserServiceInterface
{
    public function getUserCollection($query);
    public function getUser($userId);
    public function createUser($request);
    public function updateUser($userId, $request);
    public function deleteUser($userId);
    public function forgotPassword($request);
    public function resetPassword($request);
}
