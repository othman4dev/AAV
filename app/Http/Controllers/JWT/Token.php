<?php

namespace App\Http\Controllers\JWT;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;

class Token extends Controller
{
    public function token($name, $id, $email)
    {
        $key = env('SECRET_KEY');
        $payload = [
            'name' => $name,
            'id' => $id,
            'email' => $email
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }
}