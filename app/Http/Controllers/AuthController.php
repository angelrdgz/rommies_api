<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;
use JWTAuth;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
    	$credentials = $request->only('email', 'password','name');
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
            'team_name' => 'required|min:5',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->messages()
            ]);
        }

        $user = User::create([
             'email'    => $request->email,
             'password' => $request->password,
             'name' => $request->name,
         ]);

        $team = new Team();
        $team->user_id = $user->id;
        $team->name = $request->team_name;
        $team->code = $this->generateRandomString(8);
        $team->user_id = $user->id;
        $team->save();

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }
     public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->messages()
            ]);
        }
        try {
            // Attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'We can`t find an account with this credentials.'
                ], 401);
            }
        } catch (JWTException $e) {
            // Something went wrong with JWT Auth.
            return response()->json([
                'status' => 'error', 
                'message' => 'Failed to login, please try again.'
            ], 500);
        }
        // All good so return the token
        return response()->json([
            'status' => 'success', 
            'data'=> [
                'token' => $token
                // You can add more details here as per you requirment. 
            ]
        ]);
    }
    /**
     * Logout
     * Invalidate the token. User have to relogin to get a new token.
     * @param Request $request 'header'
     */
    public function logout(Request $request) 
    {
        // Get JWT Token from the request header key "Authorization"
        $token = $request->header('Authorization');
        // Invalidate the token
        try {
            JWTAuth::invalidate($token);
            return response()->json([
                'status' => 'success', 
                'message'=> "User successfully logged out."
            ]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
              'status' => 'error', 
              'message' => 'Failed to logout, please try again.'
            ], 500);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            //'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
}
