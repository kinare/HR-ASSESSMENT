<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Concerns\ApiResponder;
use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\InvitationNotice;
use App\Notifications\UserPasswordResetNotice;
use App\Notifications\UserPasswordResetSuccessNotice;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    use ApiResponder;

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $user = User::whereEmail($request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)){
            return $this->error('The provided credentials are not correct');
        }

        return $this->success([
            'user' => $user,
            'token' => $user->createToken(env('app_name'))->plainTextToken,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success('logout success');
    }

    public function reset(): JsonResponse
    {
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');
        return $this->success('Application Reset');
    }
}
