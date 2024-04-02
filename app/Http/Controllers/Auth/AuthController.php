<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\JWT\Token as JWTToken;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\CheckUserRequest;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    protected $access_token;
    public function __construct()
    {
        $this->access_token = new JWTToken();
    }
    public function Login(CheckUserRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        if (Auth::attempt($credentials)) {
            $token = $this->access_token->token($user->name, $user->id, $user->email);
            $cookie = cookie('token', $token, 60);
            if ($user->role == 'admin') {
                return response()->json(['message' => 'Login Successful Admin'], 200)->cookie($cookie);
            } else {
                return response()->json(['message' => 'Login Successful User'], 200)->cookie($cookie);
            }
        } else {
            return response()->json(['message' => 'Incorrect username or password'], 401);
        
        }
    }
    public function Register(AddUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
        Auth::login($user);
        return response()->json(['message' => 'Register successful'], 200);
    }
    public function logout()
    {
        Auth::logout();
        $cookie = Cookie::forget('token');
        return response()->json(['message' => 'Logout successful'], 200)->withCookie($cookie);
    }
}