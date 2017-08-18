<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Illuminate\Foundation\Auth\RegistersUsers;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $params = $request->only('email', 'password');

        $username = $params['email'];
        $password = $params['password'];

        if (\Auth::attempt(['email' => $username, 'password' => $password])) {
            DB::table('users')->where('id', \Auth::user()->id)->update(['is_online' => 1]);
            return \Auth::user();
        }

        return response()->json(['error' => 'Invalid username or Password'], 422);
    }

    // public function register(Request $request)
    // {
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if (\Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            DB::table('users')->where('id', \Auth::user()->id)->update(['is_online' => 1]);
            return \Auth::user();
        }
        return response()->json(['error' => 'Invalid username or Password'], 422);
    }

    public function logout(Request $request)
    {
        DB::table('users')->where('id', \Auth::user()->id)->update(['is_online' => 0]);
    }
    //     if (\Auth::attempt(['email' => $username, 'password' => $password])) {
    //         return \Auth::user();
    //     }
    //s
    //     return response()->json(['error' => 'Invalid username or Password'], 422);
    // }

    public function user(Request $request)
    {
        return $request->user();
    }
}
