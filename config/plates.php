<?php
    $viewEngine= new League\Plates\Engine();
    $viewEngine->setFileExtension('phtml');
    $viewEngine->addFolder('shared', VIEWS . 'shared');
    $viewEngine->addFolder('login', VIEWS . 'login');
    $viewEngine->addFolder('dashboard', VIEWS . 'dashboard');
    $viewEngine->addFolder('events', VIEWS . 'events');
    $viewEngine->addFolder('toasts', VIEWS . 'toasts');