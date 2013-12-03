<?php

// configure your app for the production environment

$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array(
    'cache' => __DIR__.'/../var/cache/twig',
    // this allow you to easyly clear twig cache, just opening http://yourpath/clear-cache/<key-defined-bellow>
    'clear_cache_key' => ''
    );
