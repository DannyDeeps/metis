<?php require_once '../../includes/start.php';

use Metis\System\{Login, Util};
use Metis\Users\User;
use Metis\Framework\Webpage;
use Metis\Events\Event;

if (!Login::userInSession())
    Util::redirect('login');

$webPage= (new Webpage($viewEngine, 'dashboard::main', [
    'title' => 'Dashboard'
]));

$user= User::get($_SESSION['user_id']);
$events= Event::find([ 'user_id' => $user->getId() ]);

$webPage->renderPage([
    'user' => $user,
    'events' => $events
]);