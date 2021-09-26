<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Redirect };
use Metis\Framework\Webpage;

if (!Login::userInSession()) {
    Redirect::to('login');
}

(new Webpage($viewEngine, 'pages::dashboard/main', [
    'title' => 'Dashboard'
]))->renderPage();