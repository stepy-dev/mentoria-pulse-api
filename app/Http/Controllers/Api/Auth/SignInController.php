<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\SignInRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SignInController extends Controller
{
    public function __invoke(SignInRequest $request)
    {
        $validatedData = $request->validated();

        if(!Auth::attempt($validatedData)) {
            throw ValidationException::withMessages(['email' => 'Invalid email or password.']);
        }

        $user = User::where('email', $validatedData['email'])->first();
        $accessToken = $user->createToken('API')->plainTextToken;

        return [
            'access_token' => $accessToken,
        ];
    }
}
