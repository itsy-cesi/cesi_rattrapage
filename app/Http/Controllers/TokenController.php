<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    static function check_user_token(Request $request, $user)
    {
        $token = Token::where('user_id', $user->id)
                  ->where('user_agent', $request->userAgent())
                  ->first();
        return $token ?? false;
    }

    static function add_user_token(Request $request, $user)
    {
        $token = new Token();
        $token->user_id = $user->id;
        $token->user_agent = $request->userAgent();
        $token->token = Str::random(255);
        $token->expiration_date = Carbon::now()->addDays((($request['remember'] ?? '') == 'on' ? 30 : 4));
        $token->save();
    }

    static function update_token(Request $request, $user)
    {
        $token = Token::where('user_id', $user->id)
                  ->where('user_agent', $request->userAgent())
                  ->first();

        $token->expiration_date = Carbon::parse($token->expiration_date)->addDays(4);
        $token->save();
    }
}
