<?php namespace Metis\System;

use \Metis\ORM\Models\Users\User;

class Auth
{
    public static function hashPassword(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function verifyPassword(User $user, string $password)
    {
        return password_verify($password, $user->getPassword());
    }
}
