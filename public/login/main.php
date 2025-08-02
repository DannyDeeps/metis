<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Redirect, Request as Req };
use Metis\Framework\{ ViewHandler, ActionHandler, NoticeHandler };

if (Login::userInSession()) {
    Redirect::to('/dashboard');
}

(new ActionHandler)->registerAction('attemptLogin', function() {
    try {
        Login::attemptLogin(Req::get('username'), Req::get('password'));
        Redirect::to('dashboard');
    } catch (\Exception $exc) {
        (new NoticeHandler($exc, 'danger'))->save();
    }
})->triggerAction();

(new ViewHandler($VIEW_ENGINE, [
    'title' => 'Login'
]))->renderView('pages/login/main.tpl');