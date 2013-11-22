<?php
/**
* application directories are better located out of servers web root
*
* @var $_app_dir path to application directory root (all directories except web/)
*/
$_app_dir = __DIR__.'/..';

ini_set('display_errors', 0);

require_once $_app_dir.'/../vendor/autoload.php';

$app = require $_app_dir.'/../src/app.php';
require $_app_dir.'/../config/prod.php';
require $_app_dir.'/../src/controllers.php';
$app->run();
