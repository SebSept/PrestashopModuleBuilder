<?php
/**
 * Middlewar to add time spent at the bottom of page.
 * 
 * @package Prestahop Module builder
 * @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
 * @link https://github.com/SebSept/PrestashopModuleBuilder
 */
class Chrono extends \Slim\Middleware 
{
   
    public function call() 
    {
        $start = microtime(true);
        
        $this->next->call();
        
        $out = '<p>Time : '.number_format( (microtime(true)-$start), 4 ).'</p>';
        $this->app->response->setBody( $this->app->response->getBody().$out );
    }
}

