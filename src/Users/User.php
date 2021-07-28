<?php namespace Metis\Users;

/**
 * TODO:
 *  Sanitisation & Validation on certain fields
 */

class User extends \Metis\ORM\Entity
{
// STATICS
    /** @var string $dbClass Database Class */
    public static $dbClass= "\\Metis\\Database\\Metis";

    /** @var string $dbTable Database Table */
    public static $dbTable= 'users';

// VARS
    /** @var int $id User ID */
    private $id= null;
    public function getId() { return $this->id; }
    public function setId($id) { $this->id= $id; return $this; }

    /** @var string $username Username */
    private $username= null;
    public function getUsername() { return $this->username; }
    public function setUsername($username) { $this->username= $username; return $this; }

    /** @var string $email User Email */
    private $email= null;
    public function getEmail() { return $this->email; }
    public function setEmail($email)
    {
        $email= filter_var($email, FILTER_SANITIZE_EMAIL);
        $email= filter_var($email, FILTER_VALIDATE_EMAIL);
        if (empty($email))
            throw new \Exception("Invalid Email");

        $this->email= $email;
        return $this;
    }

    /** @var string $password User Password */
    private $password= null;
    public function getPassword() { return $this->password; }
    public function setPassword($password)
    {
        $this->password= password_hash($password, PASSWORD_BCRYPT);
        return $this;
    }

// METHODS
    public function verifyPassword(string $password)
    {
        return password_verify($password, $this->password);
    }
}