<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TokenController;
use App\Models\User;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthentificatorController extends Controller
{
    use ValidatesRequests;

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password))
        {
            return response()->json([
                'form' => $request,
                'type' => 'login_failed',
                'error' => 'Invalid email or password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        if (TokenController::check_user_token($request, $user))
        {
            TokenController::update_token($request, $user);
        }
        else
        {
            TokenController::add_user_token($request, $user);
        }

        Auth::login($user);
        Session::regenerate();

        return response()->json([
            'name' => Auth::user()->name,
            'type' => 'redirect',
            'redirect' => '/'
        ], Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols(),
            ],
            'password_confirmation' => 'required',
            'dob' => [
                'required',
                'before_or_equal:' . date('Y-m-d', strtotime('-13 years')),
                'after_or_equal:' . date('Y-m-d', strtotime('-100 years')),
            ],
            'gender' => 'required|in:male,female,other',
        ],
        [
            'dob.after_or_equal' => 'You must be less than 100 years old to register',
            'dob.before_or_equal' => 'You must be at least 13 years old to register',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'type' => 'input_validation',
                'error' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'dob' => $request->dob,
            'gender' => $request->gender,
        ]);

        $token = $user->createToken('access-token')->plainTextToken;

        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'dob' => $user->dob,
                'gender' => $user->gender,
                'last_connection' => $user->last_connection,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'email_verified' => $user->email_verified_at !== null,
                'token' => $token,
            ],
            'message' => 'Registration successful',
        ], Response::HTTP_CREATED);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
