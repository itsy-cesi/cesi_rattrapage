<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Token;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all(['id', 'name', 'password'])
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name
                ];
            });

        return response()->json([
            'data' => $users,
            'message' => 'Users retrieved successfully',
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                ],
                'password_confirmation' => 'required',
                'dob' => array(
                    'required',
                    'before_or_equal:' . date('Y-m-d', strtotime("-13 years")),
                    'after_or_equal:' . date('Y-m-d', strtotime("-100 years"))
                ),
                'gender' => 'required|in:male,female,other',
            ],
            [
                'dob.after_or_equal' => 'You must be at least 13 years old to register',
                'dob.before_or_equal' => 'You must be less than 100 years old to register',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation failed',
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
        ]);

        return response()->json([
            'data' => $user,
            'redirect' => route('login'),
        ], Response::HTTP_CREATED);
    }

    public function getUserByEmailAndPassword(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $userAgent = $request->header('User-Agent');

        // Find the user with the given email address
        $user = User::where('email', $email)->first();

        // Check if the user exists and the password is correct
        if ($user && Hash::check($password, $user->password)) {
            // Check if there is an existing token for the user
            $token = Token::where('user_id', $user->id)->first();

            if ($token) {
                // If there is an existing token, update the expiration date and user agent
                $token->expiration_date = Carbon::now()->addDays(7);
                $token->user_agent = $userAgent;
                $token->save();
            } else {
                // If there is no existing token, create a new one
                $token = new Token();
                $token->user_id = $user->id;
                $token->token = Str::random(60);
                $token->expiration_date = Carbon::now()->addDays(7);
                $token->user_agent = $userAgent;
                $token->save();
            }

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
                    'token' => $token->token,
                    'expiration_date' => $token->expiration_date,
                ],
                'redirect' => route('home'),
            ], Response::HTTP_OK);
        } else {
            // Return an error response if the credentials are invalid
            return response()->json([
                'error' => 'Invalid email or password',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function getTokenByUserId(Request $request)
    {
        $userId = $request->input('user_id');
        $userAgent = $request->header('User-Agent');

        // Find the token for the given user ID
        $token = Token::where('user_id', $userId)->first();

        if ($token) {
            // Update the token's expiration date and user agent
            $token->expiration_date = Carbon::now()->addDays(7);
            $token->user_agent = $userAgent;
            $token->save();

            // Return the token
            return response()->json([
                'data' => [
                    'user_id' => $token->user_id,
                    'token' => $token->token,
                    'expiration_date' => $token->expiration_date->format('Y-m-d H:i:s'),
                    'user_agent' => $token->user_agent,
                ],
                'message' => 'Token retrieved successfully',
            ], Response::HTTP_OK);
        } else {
            // Return an error response if no token was found for the given user ID
            return response()->json([
                'error' => 'No token found for the given user ID',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function show(User $user)
    {
        $created_at = $user->created_at->formatLocalized('%d/%m/%Y %H:%M:%S');
        $last_connection = $user->last_connection ? $user->last_connection->formatLocalized('%d/%m/%Y %H:%M:%S') : null;


        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'dob' => $user->dob,
                'gender' => $user->gender,
                'last_connection' => $last_connection,
                'created_at' => $created_at,
                'email_verified' => $user->email_verified_at !== null,
            ],
            'message' => 'User retrieved successfully',
        ], Response::HTTP_OK);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'dob' => 'required|date_format:Y-m-d',
            'gender' => 'required|in:male,female',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->dob = $request->input('dob');
        $user->gender = $request->input('gender');
        $user->save();

        return response()->json([
            'data' => $user,
            'message' => 'User updated successfully',
        ], Response::HTTP_OK);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ], Response::HTTP_OK);
    }
}
