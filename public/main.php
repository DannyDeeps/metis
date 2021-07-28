<?php require_once '../includes/start.php';

use Metis\System\{ Login, Util };
use Metis\Framework\Webpage;

if (!Login::userInSession())
    Util::redirect('login');

$webPage= new Webpage($viewEngine, 'dashboard::main', [
    'title' => 'Dashboard'
]);

$notice= null;
if (!empty($notice)) {
    $webPage->requireJs('toasts-init.js');
    $webPage->assignData([ 'notice' => $notice ]);
}

$webPage->renderPage();