<?php
namespace App\Http\Service;

use App\Models\User;
use App\Http\Requests\RegisterRequest;

class UserService{
    public function createFormRequest(RegisterRequest $request) : User {
        $user = new User();
        $user->email = $request->get('email');
        $user->password = $request->get('password');
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->save();

        return $user;
    }
}