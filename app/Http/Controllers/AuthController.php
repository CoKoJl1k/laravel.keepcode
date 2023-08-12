<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\JWTService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    private UserService $newsService;
    private JWTService $jwtService;

    public function __construct(UserService $newsService, JWTService $jwtService)
    {
        $this->newsService = $newsService;
        $this->jwtService = $jwtService;
    }


    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $errors = $this->newsService->validateRegister($request);
        if(!empty($errors['message'])) {
            return response()->json(['status' => 'fail', 'message' => $errors['message']]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $payload['user_id'] = $user->id;
        $payload['name'] = $user->name;
        $payload['email'] = $user->email;

        $token = $this->jwtService->generateToken($payload);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

}
