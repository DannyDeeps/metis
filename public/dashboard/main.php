<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Util, Session };
use Metis\Framework\Webpage;
use Metis\Events\Event;

if (!Login::userInSession())
    Util::redirect('login');

(new Webpage($viewEngine, 'dashboard::main', [
    'title' => 'Dashboard',
    'events' => Event::findAllByUserId(Session::get('user_id'))
]))->renderPage();