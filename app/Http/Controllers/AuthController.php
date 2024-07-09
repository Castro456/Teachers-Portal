<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Used to take to Login page
     */
    public function login() {
        return view('auth.login');
    }


    /**
     * This method used to authenticate the user using email, password provided
     * 
     * @param email
     * @param password
     * 
     * @return json
     */
    public function authenticate()
    {
        $validate = validator()->make(request()->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->errors();

        if ($validate->any()) {
            return response()->json([
                'status' => 'validation_failed',
                'message' => $validate->first()
            ], 422); //Unprocessable entry
        }

        $credentials = array(
            'email' => request('email'),
            'password' => request('password')
        );

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate(); //Generate new session.

            return response()->json([
                'status' => 'success',
                'message' => 'Logged in successfully'
            ], 200); //success
        } 
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email or password is incorrect'
            ], 404); //Not found
        }
    }


    /**
     * This method is used to take to register view page
     */
    public function register()
    {
        return view('auth.register');
    }


    /**
     * This method is used to store a new entry user to the database
     * 
     * @param name
     * @param email
     * @param password
     * 
     * @return json
     */
    public function store()
    {
        $validate = validator()->make(request()->all(), [
            'name' => 'bail|required',
            'email' => 'bail|required|email|unique:users,email',
            'password' => 'bail|required|min:8'
        ])->errors();

        if($validate->any()) {
            return response()->json([
                'status' => 'validation_failed',
                'message' => $validate->first()
            ], 422); //Unprocessable entry
        }

        try {
            $new_user = User::create([
                'name' => request('name'),
                'email' => request('email'),
                'password' => Hash::make(request('password')) //Hashing the password for security.
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'There was an error occurred, Please try again'
            ], 500); //Internal server error
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Account created successfully, Login now!'
        ], 200); //success
    }


    /**
     * This method is used to clear sessions and logout the user
     */
    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate(); //clear sessions
        request()->session()->regenerateToken();

        return redirect()->route('login'); //clear sessions and route the url to login
    }
}
