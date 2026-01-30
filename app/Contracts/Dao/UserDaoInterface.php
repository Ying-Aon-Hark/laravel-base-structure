<?php

namespace App\Contracts\Dao;

interface UserDaoInterface
{
    public function getUserCollection($query);
    public function getUser($userId);
    public function createUser($request);
    public function updateUser($userId, $request);
    public function deleteUser($userId);
    public function sendPasswordResetLink($request);
    public function getUserByEmail($email);
    public function resetPassword($request);
}
