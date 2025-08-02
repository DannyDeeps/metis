<?php require_once __DIR__ . '/../../includes/start.php';

$newUserName = $argv[1];
$email = $argv[2];
$password = $argv[3];

use Metis\Users\User;
use Metis\Database\Dev;

$newUser= new User(new Dev);
$newUser
    ->setUsername($newUserName)
    ->setEmail($email)
    ->setPassword($password)
    ->save();

echo "Created User with ID " . $user->getUserId() . "\n";