<?php require_once '../../includes/start.php';

use Metis\System\Login;
use Metis\Framework\ViewHandler;

Login::required();

(new ViewHandler($VIEW_ENGINE, [
    'title' => 'Dashboard'
]))->renderView('pages/dashboard/main.tpl');