<?php
/**
 * Production bootstrap file
 * 
 * @package Prestahop Module builder
 * @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
 * @link https://github.com/SebSept/PrestashopModuleBuilder
 */

/**
 * application directories are better located out of servers web root
 *
 * @var APP_DIR path to application directory root (all directories except web/)
 */
define('APP_DIR', __DIR__ . '/..');

// composer autoloader
$loader = require_once APP_DIR.'/vendor/autoload.php';

// load config
$config = require(APP_DIR.'/config/prod.php');

// run app
require(APP_DIR.'/src/app.php');