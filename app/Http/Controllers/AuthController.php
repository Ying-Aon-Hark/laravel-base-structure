<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Service\UserServiceInterface;


class AuthController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    // User Login and Token Creation
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    // User Logout (Revoke Token)
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }

    // Register User
    public function register(Request $request)
    {
        $this->validateUser($request);
        $this->userService->createUser($request);
        return response()->json(['message' => 'Register Success'], 201);
    }

    /**
     * Forgot Password
     * @method forgotPassword
     * @param  Request $request
     * @return void
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = $this->userService->forgotPassword($request);
        $message = $user
            ? ['message' => 'Reset Password Link Sent']
            : ['message' => 'User not found'];
        $status = $user ? 200 : 404;
        return response()->json($message, $status);
    }

    /**
     * Reset Password
     * @method resetPassword
     * @param  Request $request
     * @return Json
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required',
        ]);

        $status = $this->userService->resetPassword($request);
        $message = $status
            ? ['message' => 'Password Reset Success']
            : ['message' => 'Password Reset Failed'];
        return response()->json($message, $status ? 200 : 400);
    }

    // Validate User Registration
    private function validateLogin($request)
    {
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }

    // Validate User Registration
    private function validateUser($request)
    {
        return $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'company' => 'required',
            'country' => 'required',
        ]);
    }
}
