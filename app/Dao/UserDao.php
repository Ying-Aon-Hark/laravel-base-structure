<?php

namespace App\Dao;

use App\Models\User;
use App\Models\Role;
use App\Http\Resources\UserResource;
use App\Contracts\Dao\UserDaoInterface;
use App\Filters\OrSearchFilter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class UserDao implements UserDaoInterface
{
    /**
     * show all users
     * @method getUserCollection
     * @return void
     */
    public function getUserCollection($query)
    {
        $itemsPerPage = $query['itemsPerPage'] ?? config('constants.PAGINATION');
        $users = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::custom('OrSearch', new OrSearchFilter([
                    'firstname',
                    'lastname',
                    'username',
                    'company',
                    'email',
                    'roles.name',
                ])),
                AllowedFilter::exact('status')
            ])
            ->allowedSorts(['created_at'])
            ->paginate($itemsPerPage);

        return UserResource::collection($users);
    }

    /**
     * Show user profile
     * @method showUserDetail
     * @param  int $userId
     * @return User
     */
    public function getUser($userId)
    {
        $user = User::where('id', $userId)->first();
        $user->load('roles');
        return new UserResource($user);
    }

    /**
     * create user function
     * @method create
     * @param  Object $request
     * @return void
     */
    public function createUser($request)
    {
        $user =  User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'company' => $request->company,
            'country' => $request->country,
            'status' => $request->status ?? 'inactive',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        if ($request->roles && count($this->getUserRoles()) > 0) {
            $user->roles()->attach($request->roles, [
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        return new UserResource($user);
    }

    /**
     * update user by id
     * @method updateUser
     * @param  int $userId [description]
     * @param  Object $request [description]
     * @return void
     */
    public function updateUser($userId, $request)
    {
        $user =  User::where('id', $userId)
            ->update([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'company' => $request->company,
                'country' => $request->country,
                'status' => $request->status ?? 'inactive',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        if ($request->roles && count($this->getUserRoles()) > 0) {
            $user = User::find($userId);
            $currentRoles = $user->roles->pluck('id')->toArray();
            $newRoles = $request->roles;

            // Attach new roles
            $rolesToAttach = array_diff($newRoles, $currentRoles);
            if (!empty($rolesToAttach)) {
                $user->roles()->attach($rolesToAttach, [
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            // Detach removed roles
            $rolesToDetach = array_diff($currentRoles, $newRoles);
            if (!empty($rolesToDetach)) {
                $user->roles()->detach($rolesToDetach);
            }
        }

        return new UserResource($user);
    }


    /**
     * delete User by id
     * @method deleteUser
     * @param  int $userId [description]
     * @return void
     */
    public function deleteUser($userId)
    {
        User::where('id', $userId)->delete();
    }

    /**
     * get all roles
     * @method getUserRoles
     * @return array
     */
    public function getUserRoles()
    {
        return Role::all()->toArray();
    }

    /**
     * Get user by email
     * @method getUserByEmail
     * @param  string $email
     * @return UserResource|null
     */
    public function getUserByEmail($email)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            return new UserResource($user);
        }
        return null;
    }

    /**
     * forgot password
     * @method forgotPassword
     * @param  Object $request
     * @return void
     */
    public function sendPasswordResetLink($request)
    {
        return Password::sendResetLink($request->only('email'));
    }

    /**
     * reset password
     * @method resetPassword
     * @param  Object $request
     * @return void
     */
    public function resetPassword($request)
    {
        return Password::reset($request, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });
    }
}
