<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Service\UserService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller
{
    public const TOKEN_NAME = 'ApiToken';

    public function registration(RegisterRequest $request, UserService $service) : JsonResponse {
        $user = $service->createFormRequest($request);
        return response()->json([
            "success" => true,
            "message" => "success",
            "token" => $user->createToken(self::TOKEN_NAME)->plainTextToken
        ]);
    }

    public function login(LoginRequest $request) : JsonResponse {
        $user = User::where('email', $request->get('email'))->first();

        if(!$user || $request->get('password') !== $user->password){
            throw new UnauthorizedException();
        }
        $user->tokens()->delete();

        return response()->json([
            "success" => true,
            "message" => "success",
            "token" => $user->createToken(self::TOKEN_NAME)->plainTextToken
        ]);


    }
}
