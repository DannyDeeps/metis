<?php
    require_once __DIR__.'/../includes/start.php';

    $user_id = $argv[1];
    $newName = $argv[2];

    $user = $entityManager->find('User', $user_id);

    if ($user === null) {
        echo "User $user_id does not exist.\n";
        exit(1);
    }

    $user->setDisplayName($newName);

    $entityManager->flush();