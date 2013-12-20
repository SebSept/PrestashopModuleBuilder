<?php
/**
* Prestashop Module builder
*
* application directories are better located out of servers web root
*
* @var $_app_dir path to application directory root (all directories except web/)
* @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
*/

$_app_dir = __DIR__.'/..';

use Symfony\Component\Debug\Debug;

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1'))
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

require_once $_app_dir.'/vendor/autoload.php';

Debug::enable();

$app = require $_app_dir.'/src/app.php';
require $_app_dir.'/config/dev.php';
require $_app_dir.'/src/controllers.php';
$app->run();
