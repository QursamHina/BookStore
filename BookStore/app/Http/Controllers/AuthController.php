<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Passport;
use App\Models\User as UserModel;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate user input
        $this->validator($request->all())->validate();

        // Create a new user record
        $user = $this->create($request->all());

        // Issue a Passport token for the newly registered user
        $token = $user->createToken('MyApp')->accessToken;

        // Return a JSON response with the user data and token
        return response()->json([
            'user' => $user,
            'access_token' => $token,
        ]);
    }

    // Validation rules for user registration
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
    }
    public function login(Request $request)
    {
        // Validate user input
        $this->validateLogin($request);

        // Attempt to authenticate the user
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication successful

            // Get the authenticated user
            $user = auth()->user();

            // Issue a Passport token for the authenticated user
            $token = $user->createToken('MyApp')->accessToken;

            // Return a JSON response with the user data and token
            return response()->json([
                'user' => $user,
                'access_token' => $token,
            ]);
        }

        // Authentication failed
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
    }

    // Create a new user record
    protected function create(array $data)
    {
        return UserModel::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
