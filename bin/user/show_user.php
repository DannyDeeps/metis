<?php
    require_once __DIR__.'/../includes/start.php';

    $user_id = $argv[1];
    $user = $entityManager->find('User', $user_id);

    if ($user === null) {
        echo "No user found.\n";
        exit(1);
    }

    echo sprintf("-%s\n", $user->getDisplayName());