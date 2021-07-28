<?php namespace Metis\System;

use Metis\Users\User;

class Login
{
    public static function userInSession()
    {
        $detectedUser= (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : null;
        if ($detectedUser)
            return true;
        return false;
    }

    public static function attemptLogin(string $username, string $password)
    {
        if (empty($username) || empty($password))
            throw new \Exception("All fields required");

        $user= User::findOne([ 'username' => $username ]);
        if (empty($user))
            throw new \Exception("User not found");

        $verified= $user->verifyPassword($password);
        if (!$verified)
            throw new \Exception("Incorrect login/password");

        $_SESSION['user_id']= $user->getId();
    }

    public static function hashPassword(string $password)
    {
        $password= password_hash($password, PASSWORD_BCRYPT);
        return $password;
    }

    public function verifyPassword(User $user, string $password)
    {
        return password_verify($password, $user->getPassword());
    }
}