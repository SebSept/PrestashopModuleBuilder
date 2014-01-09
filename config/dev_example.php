<?php
/**
 * Development config 
 * 
 * @package Prestahop Module builder
 * @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
 * @link https://github.com/SebSept/PrestashopModuleBuilder
 */

return array(
    'slim' => array(
        'debug' => true,
        'log.level' => \Slim\Log::DEBUG,
//        'log.enabled' => true,
        'mode' => 'development',
//        'debugtofile' => '/home/seb/dev/htdocs/tests/prestashop15/modules/mymodule/mymodule.php',
        'debugtofile' => false,
        ),
    'twig' => array(
        'path' => array(__DIR__.'/../templates'),
        'options' => array(
            'debug' => true,
//            'cache' => false, // false is default
        ),
        // this allow you to easyly clear twig cache, just opening http://yourpath/clear-cache/<key-defined-bellow>
        'clear_cache_key' => ''
    ),
    'cache' => array(
        'conditions' => array(
            'max-age' => 0 // 0 seconds - no cache
        ),
        'dir' => __DIR__.'/../var/cache/sebsept/',
    ),
);
