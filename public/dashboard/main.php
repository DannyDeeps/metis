<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Session, Redirect };
use Metis\Framework\Webpage;
use Metis\ORM\Models\Events\Event;

if (!Login::userInSession()) {
    Redirect::to('login');
}

(new Webpage($viewEngine, 'pages::dashboard/main', [
    'title' => 'Dashboard',
    'events' => Event::findAllByUserId(Session::get('user_id'))
]))->renderPage();