<?php

namespace App\Http\Controllers\Repository\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository 
{
    public function login($data)
    {
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            Auth::user()->tokens()->delete();
            $user = Auth::user();
            return [
                'user' => [
                    'id' => $user->id,
                    'user_id' => $user->user_id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'token' => $user->createToken('ApiToken')->plainTextToken,
            ];
        }
        return 'Wrong Username or Password';
    }
    public function create($data)
    {
        $res = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' =>  Hash::make($data['password']),
        ]);
        return $res;
    }
    public function logout()
    {
        return Auth::user()->tokens()->delete();
    }

    public function register($input)
    {
        $input->getData();
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);
    }
}
