<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        try {
            $validator = validator($request->all(),
                [
                    'email' => 'email | required',
                    'password' => 'required'
                ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'errors' => [
                        'error' => [
                            'Incorrect login or password'
                        ]
                    ]
                ], 403);
            }
            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error in Login');
            }
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => auth()->user()
            ]);
        } catch (Exception $error) {
            return response()->json([
                'errors' => $error,
            ], 403);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }

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
            return response()->json(['errors' => ['Invalid credentials provided']]);
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
            'token_type' => 'Bearer',
            'user' => $user]);
    }
}
