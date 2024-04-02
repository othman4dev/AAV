<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = env('SECRET_KEY');
        $tack_token = $request->cookie('token');
        if ($tack_token) {
            $decod_token = JWT::decode($tack_token, new Key($key, 'HS256'));
            $user = User::where('email', $decod_token->email)->first();
            if ($user) return $next($request);
        } else {
            return response()->json(['Is not Authorized login please'], 401);
        }
    }
}