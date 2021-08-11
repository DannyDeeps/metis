<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Session, Util };
use Metis\Users\User;
use Metis\Framework\Webpage;
use Metis\Events\{ Event, Type };
use Metis\Errors\Notice;

if (!Login::userInSession())
    Util::redirect('login');

$user= User::get($_SESSION['user_id']);

$notice= null;
if (isset($_REQUEST['createEvent'])) {
    try {
        $type= (!empty($_REQUEST['type_new'])) ? $_REQUEST['type_new'] : $_REQUEST['type'];

        $newEvent= new Event;
        $newEvent
            ->setUserId($user->getId())
            ->setEventType($type)
            ->setDescription($_REQUEST['description'])
        ->save();

        Util::redirect('events');
    } catch (Exception $exc) {
        Notice::create($exc->getMessage(), $exc->getCode(), $exc, 'danger');
    }
}

$webPage= new Webpage($viewEngine, 'events::new', [
    'title' => 'New Event'
]);

if (!empty(Session::get('notice'))) {
    $webPage->requireJs('toasts-init.js');
    $webPage->assignData([ 'notice' => Session::get('notice') ]);
}

$webPage->renderPage([
    'user' => $user,
    'eventTypes' => Type::find()
]);