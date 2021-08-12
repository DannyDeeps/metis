<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Util, Session };
use Metis\Framework\Webpage;
use Metis\Exceptions\NoticeException;

if (Login::userInSession())
    Util::redirect('dashboard');

if (isset($_REQUEST['attemptLogin']))
{
    try
    {
        Login::attemptLogin($_REQUEST['username'], $_REQUEST['password']);
        Util::redirect('dashboard');
    }
    catch (\Exception $exc)
    {
        Session::addNotice(new NoticeException($exc, 'danger'));
    }
}

(new Webpage($viewEngine, 'login::main', [
    'title' => 'Login'
]))->renderPage();