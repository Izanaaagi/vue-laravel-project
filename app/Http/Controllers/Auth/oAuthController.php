<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class oAuthController extends Controller
{
    public function redirectToProvider($provider)
    {

        if ($provider == 'google') {
            $redirectUrl = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
            return response()->json(['url' => $redirectUrl]);
        }
        return response()->json(['errors' => ['Provider doesn\'t exists']], 404);
    }

    public function redirectToProviderCallback($provider)
    {

        if ($provider != 'google') {
            return response()->json(['errors' => ['Provider doesn\'t exists']], 404);
        }

        try {
            $userFromSocial = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['errors' => ['Invalid credentials provided']], 401);
        }

        $user = User::where('email', $userFromSocial->getEmail())->first();

        if (is_null($user)) {
            $user = User::create([
                'name' => $userFromSocial->getName(),
                'email' => $userFromSocial->getEmail(),
                'avatar_path' => $userFromSocial->getAvatar(),
                'provider' => $provider,
                'provider_id' => $userFromSocial->getId(),
                'email_verified_at' => now()
            ]);
            $user->assignRole('user');
        }

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return view('callback', [
            'access_token' => $tokenResult,
            'token_type' => 'Bearer']);
    }
}
