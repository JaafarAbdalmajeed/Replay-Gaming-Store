<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' =>'required|email|max:255',
            'password' =>'required|string|min:6',
            'device_name' => 'string|max:255',
            'abilities' => 'nullable|array'
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post('device_name', $request->userAgent());
            $token = $user->createToken($device_name,$request->post('abilities'));
            return Response::json([
                'code' => 100,
                'token' => $token->plainTextToken,
                'user' => $user
            ], 201);
        }

        return Response::json([
            'code' => 0,
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();

        if (null === $token) {
            $user->currentAccessToken()->delete();
            return;
        }
        $personalAccessToken = PersonalAccessToken::findToken($token);

        if (!$personalAccessToken) {
            return response()->json(['message' => 'Token not found.'], 404);
        }

        if (
            $user->id === $personalAccessToken->tokenable_id &&
            get_class($user) === $personalAccessToken->tokenable_type
        ) {
            $personalAccessToken->delete();
            return response()->json(['message' => 'Token deleted successfully.']);
        }

        return response()->json(['message' => 'Unauthorized.'], 403);
    }
}
