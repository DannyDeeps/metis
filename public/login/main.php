<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Util };
use Metis\Errors\MetisNotice;
use Metis\Framework\Webpage;

if (Login::userInSession())
    Util::redirect('dashboard');

$notice= null;
if (isset($_REQUEST['attemptLogin'])) {
    try {
        Login::attemptLogin($_REQUEST['username'], $_REQUEST['password']);
        Util::redirect('dashboard');
    } catch (\Exception $exc) {
        $notice= new MetisNotice($exc->getMessage(), $exc->getCode(), $exc, 'danger');
    }
}

$webPage= new Webpage($viewEngine, 'login::main', [
    'title' => 'Login'
]);

if (!empty($notice)) {
    $webPage->requireJs('toasts-init.js');
    $webPage->assignData([ 'notice' => $notice ]);
}

$webPage->renderPage();