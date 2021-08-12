<?php namespace Metis\System;

use Metis\Users\User;
use Metis\System\Session;

class Login
{
    public static function userInSession()
    {
        return !empty(Session::get('user_id')) ?? false;
    }

    public static function attemptLogin(string $username, string $password)
    {
        if (empty($username) || empty($password))
        {
            throw new \Exception("All fields required");
        }

        $user= User::findByUsername($username);
        if (empty($user))
        {
            throw new \Exception("User not found");
        }

        $verified= self::verifyPassword($user, $password);
        if (!$verified)
        {
            throw new \Exception("Incorrect login/password");
        }

        Session::set('user_id', $user->getId());
    }

    public static function hashPassword(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function verifyPassword(User $user, string $password)
    {
        return password_verify($password, $user->getPassword());
    }
}