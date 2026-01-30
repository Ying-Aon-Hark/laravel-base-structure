<?php

namespace App\Service;

use App\Contracts\Dao\UserDaoInterface;
use App\Contracts\Service\UserServiceInterface;

class UserService implements UserServiceInterface
{
    private $userDao;

    /**
     * Constructor
     * @method __construct
     * @param  UserDaoInterface $userDao
     */
    public function __construct(UserDaoInterface $userDao)
    {
        $this->userDao = $userDao;
    }

    /**
     * Show all user on database
     * @method getUserCollection
     * @return void
     */
    public function getUserCollection($query)
    {
        return $this->userDao->getUserCollection($query);
    }

    /**
     * Show user profile
     * @method getUser
     * @param  int $userId
     * @return void
     */
    public function getUser($userId)
    {
        return $this->userDao->getUser($userId);
    }

    /**
     * create new user
     * @method create
     * @param  Object $request user info data
     * @return void
     */
    public function createUser($request)
    {
        return $this->userDao->createUser($request);
    }

    /**
     * Update user by id
     * @method updateUser
     * @param  int $userId
     * @param  Object $request Updated User data
     * @return void
     */
    public function updateUser($userId, $request)
    {
        $result = $this->userDao->updateUser($userId, $request);
        if ($result) {
            return $this->userDao->getUser($userId);
        }
        return null;
    }


    /**
     * Delete user by id
     * @method deleteUser
     * @param  int $userId
     * @return void
     */
    public function deleteUser($userId)
    {
        $this->userDao->deleteUser($userId);
    }

    /**
     * Forgot Password
     * @method forgotPassword
     * @param  Object $request
     * @return void
     */
    public function forgotPassword($request)
    {
        $user = $this->userDao->getUserByEmail($request->email);
        if ($user) {
            return $this->userDao->sendPasswordResetLink($request);
        }
        return false;
    }

    /**
     * Reset Password
     * @method resetPassword
     * @param  Object $request
     * @return void
     */
    public function resetPassword($request)
    {
        return $this->userDao->resetPassword($request->only('email', 'password', 'token'));
    }
}
