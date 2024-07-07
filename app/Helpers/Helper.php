<?php

namespace App\Helpers;

use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Str;

class Helper
{
    public static function GenerateToken($length = 64){
        do {
            $token = Str::random($length); // Generate a random string
            // Check if the token already exists in the users table
            $userWithToken = User::where('token', $token)->first();
        } while ($userWithToken); // Keep generating until a unique token is found

        return $token;
    }
    public static function SeperateBearer($request){
        $bearerToken = $request;
        $token = substr($bearerToken,7);
        return $token;
    }
}
