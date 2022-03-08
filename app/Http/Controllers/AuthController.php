<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function issueToken(Request $request): JsonResponse
    {
        $user = User::whereEmail($request->input('username'))
            ->firstOrFail();

        if (! Hash::check($request->input('password'), $user->password)){
            throw new \Exception('Invalid credentials.', 401);
        }

        $token = $user->createToken($request->userAgent() . '-' . $request->ip());

        return response()->json(array_merge($user->toArray(), ['access_token' => $token->plainTextToken]));
    }
}
