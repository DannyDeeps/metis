<?php require_once '../includes/start.php';

use Metis\Users\User;

// $user= (new User)->findByUsername('DannyDeeps');
$user= User::findByUsername('DannyDeeps');


// echo '<pre>' . print_r($user, true) . '</pre>';

echo '<pre>' . var_dump($user) . '</pre>';

// echo '<pre>' . print_r([
//     'class' => get_class($class),
//     'properties' => get_object_vars($class),
//     'methods' => get_class_methods($class)
// ], true) . '</pre>'; // kill

exit;