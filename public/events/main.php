<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Redirect, Session };
use Metis\Framework\Webpage;
use Metis\Events\Controller;
use Metis\ORM\Models\Users\User;

if (!Login::userInSession()) {
    Redirect::to('login');
}

(new Webpage($viewEngine, 'pages::events/main', [
    'title' => 'Events',
    'user' => User::get(Session::get('user_id')),
    'events' => Controller::getUserEvents(Session::get('user_id'))
]))->renderPage();