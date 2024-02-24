<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Controllers\Repository\Auth\UserRepository;

class UserController extends BaseController
{
    private $repo;

    function __construct()
    {
        $this->repo = new UserRepository();
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:required',
            'password' => 'required|min:8|max:64',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 442);
        }
        $input = Arr::only($request->all(), ['email', 'password']);


        $res = $this->repo->login($input);
        if (is_array($res)) {
            return $this->sendResponse($res, 'user login successfully.');
        }
        return $this->sendResponse($res, 'error');
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'min:8|max:64',
            'user_id' => 'unique:users',
            'email' => 'required|email:required|unique:users',
            'password' => 'required|min:8|max:64',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 442);
        }

        $input = Arr::only($request->all(), ['email', 'password', 'name', 'user_id']);


        return $this->sendResponse($this->repo->create($input), 'user created successfully');
    }
    public function register(RegisterRequest $request)
    {
        $input = Arr::only($validate,['name','email','password']);

        return $this->sendResponse($this->repo->register($input), 'account registered');
    }
    public function logout()
    {
        return $this->sendResponse($this->repo->logout(), 'user logout');
    }
}
