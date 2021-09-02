<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Redirect, Session, Request };
use Metis\Framework\Webpage;
use Metis\Exceptions\MetisException;
use Metis\ORM\Models\Users\User;

if (Login::userInSession()) {
    Redirect::to('dashboard');
}

if (isset($_REQUEST['attemptLogin'])) {
    try {
        Login::attemptLogin(Request::get('username'), Request::get('password'));
        Redirect::to('dashboard');
    } catch (\Exception $exc) {
        Session::addNotice(new MetisException($exc, 'danger'));
    }
}

(new Webpage($viewEngine, 'pages::login/main', [
    'title' => 'Login'
]))->renderPage();