<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Util };
use Metis\Users\User;
use Metis\Framework\Webpage;
use Metis\Events\Event;

if (!Login::userInSession())
    Util::redirect('login');

$user= User::get($_SESSION['user_id']);
$events= Event::find([ 'user_id' => $user->getId() ]);

$webPage= new Webpage($viewEngine, 'events::main', [
    'title' => 'Events'
]);

$webPage->renderPage([
    'user' => $user,
    'events' => $events
]);