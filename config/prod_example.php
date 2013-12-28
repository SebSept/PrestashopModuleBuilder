<?php
/**
 * Production config 
 * 
 * @package Prestahop Module builder
 * @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
 * @link https://github.com/SebSept/PrestashopModuleBuilder
 */

return array(
    'slim' => array(
        'debug' => false,
        'log.level' => \Slim\Log::DEBUG,
        'log.enabled' => false,
        'mode' => 'production',
        'debugtofile' => false,
        ),
    'twig' => array(
        'path' => array(__DIR__.'/../templates'),
        'options' => array(
            'cache' => __DIR__.'/../var/cache/twig',
            // this allow you to easyly clear twig cache, just opening http://yourpath/clear-cache/<key-defined-bellow>
            'clear_cache_key' => 'f2fa0bd05dd7448155b0c5a72e2a222df9dd6f0'
        )
    )
);
