<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Redirect, Session };
use Metis\Framework\Webpage;
use Metis\ORM\Models\Users\User;
use Metis\ORM\Models\Events\Event;

if (!Login::userInSession()) {
    Redirect::to('login');
}

(new Webpage($viewEngine, 'pages::events/main', [
    'title' => 'Events',
    'user' => User::get(Session::get('user_id')),
    'events' => Event::findAllWhere([ 'user_id' => Session::get('user_id') ])
]))->renderPage();