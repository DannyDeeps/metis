<?php require_once __DIR__.'/../includes/start.php';

$userRepository = $entityManager->getRepository('User');
$users = $userRepository->findAll();

foreach ($users as $user) {
    echo sprintf("-%s\n", $user->getDisplayName());
}