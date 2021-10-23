<?php

namespace Metis\System;

use Metis\System\{ Session, Auth };
use Metis\ORM\Models\Users\User;

class Login
{
    public static function userInSession()
    {
        return !empty(Session::get('user_id')) ?? false;
    }

    public static function attemptLogin(string $username, string $password)
    {
        if (empty($username) || empty($password)) {
            throw new \Exception("All fields required");
        }

        $user= User::findByUsername($username);
        if (empty($user)) {
            throw new \Exception("User not found");
        }

        $verified= Auth::verifyPassword($user, $password);
        if (!$verified) {
            throw new \Exception("Incorrect login/password");
        }

        Session::set('user_id', $user->getId());
    }

    public static function required()
    {
        if (!Login::userInSession()) {
            Redirect::to('login');
        }
    }
}