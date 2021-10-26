<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
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
    private function jwt(User $user, $remember_me = 30)
    {
        $payload = [
            'iss' => env('APP_NAME', 'Lumen'),
            'sub' => $user->id,
            'name' => $user->name,
            'whatsapp' => $user->whatsapp,
            'email' => $user->email,
            'telegram_name' => $user->telegram_name,
            'telegram_id' => $user->telegram_id,
            'created_at' => Carbon::parse($user->created_at)->timestamp,
            'iat' => time(),
            'exp' => time() + 3600 * 24 * $remember_me //token expiry X-days
        ];

        return JWT::encode($payload, env('APP_KEY', 'walidganteng'));
    }


    /**
     ** Register an account.
     * 
     * @return void
     */

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required',
            'name' => 'required|max:255',
            'whatsapp' => 'required|max:255',
            'telegram_id' => 'required|max:255',
            'telegram_name' => 'max:255'
        ]);

        if (User::where('email', $request->email)->first())
            return response()->json([
                'success' => false,
                'message' => 'Alamat email telah terdaftar.'
            ], 422);

        if (User::where('whatsapp', $request->whatsapp)->first())
            return response()->json([
                'success' => false,
                'message' => 'No. WhatsApp telah terdaftar.'
            ], 422);

        if (User::where('telegram_id', $request->telegram_id)->first())
            return response()->json([
                'success' => false,
                'message' => 'ID Telegram telah terdaftar.'
            ], 422);


        $request = new Request($request->all());
        $request->merge([
            'password' => Hash::make($request->password)
        ]);
        $request->merge([
            'role' => 'member'
        ]);

        $user = User::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Register successfull.',
            'data' => $user,
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

        if (!empty($request->whatsapp) && $request->has('whatsapp')) {
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
            return response()->json([
                'success' => false,
                'message' => 'Account is not registered.'
            ], 400);

        if (!Hash::check($request->password, $user->password))
            return response()->json([
                'success' => false,
                'message' => 'Your password is wrong.'
            ], 422);

        return response()->json([
            'success' => true,
            'message' => 'Login successfull.',
            'data' => $user,
            'token' => $this->jwt($user)
        ]);
    }


    /**
     ** Show an account.
     * 
     * @return void
     */

    public function show(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Me found.',
            'data' => $request->auth
        ]);
    }
}
