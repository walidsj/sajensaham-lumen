<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    /**
     ** Encode json web token.
     *  https://chalidade.medium.com/authentication-token-for-lumen-with-php-jwt-5686f796f8d5
     * 
     *  @return void
     */
    private function jwt(User $user)
    {
        $payload = [
            'iss' => env('APP_NAME', 'Lumen'),
            'sub' => $user->id,
            'user' => $user,
            'iat' => time(),
            'exp' => time() + 3600 * 24 * 7 //token expiry 7 days
        ];

        return JWT::encode($payload, env('JWT_KEY', 'walidganteng'));
    }

    /**
     ** Register an account.
     * 
     * @return void
     */

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required',
            'name' => 'required|max:255',
            'whatsapp' => 'required|unique:users|max:255',
            'telegram_id' => 'required|unique:users|max:255',
            'telegram_name' => 'max:255'
        ], [
            'unique' => 'The :attribute has been registered.'
        ]);

        $request = new Request($request->all());
        $request->merge([
            'password' => Hash::make($request->password)
        ]);
        $request->merge([
            'role' => 'member'
        ]);

        $user = User::create($request->all());

        return response()->json([
            'message' => 'Register successfull.',
            'user' => $user,
            'token' => $this->jwt($user)
        ]);
    }

    /**
     ** Login an account.
     * 
     * @return void
     */

    public function login(Request $request)
    {
        $user = [];

        if ($request->has('whatsapp')) {
            $this->validate($request, [
                'whatsapp' => 'required',
                'password' => 'required'
            ]);
            $user = User::where('whatsapp', $request->whatsapp)->first();
        } else {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            $user = User::where('email', $request->email)->first();
        }

        if (empty($user))
            return response()->json(['message' => 'Account is not registered.'], 400);

        if (!Hash::check($request->password, $user->password))
            return response()->json(['message' => 'Your password is wrong.'], 422);

        return response()->json([
            'message' => 'Login successfull.',
            'user' => $user,
            'token' => $this->jwt($user)
        ]);
    }

    public function show(Request $request)
    {
        return response()->json([
            'message' => 'Me found.',
            'me' => $request->auth
        ]);
    }
}
