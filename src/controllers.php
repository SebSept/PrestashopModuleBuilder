<?php
/**
* Prestashop Module builder
*
* @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
**/

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Validator\Constraints as Assert;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider());
$app->register(new ValidatorServiceProvider());

$app['PrestashopModuleGenerator'] = function($app) { return new PrestashopModuleGenerator($app); };
$app['highlighter'] = function() { return new FSHL\Highlighter(new \FSHL\Output\Html());} ;

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage')
;

$app->match('/form', function(Request $request) use($app) 
{
    // some default data for when the form is displayed the first time in debug mode
    if($app['debug'])
    {
        $data = array(
            'need_instance' => false,
            'version' => '0.1',
            'name' => 'MyModule',
            'displayName' => 'My module to foo',
            'description' => 'adds a bar on each fu',
            'author' => 'Module man'
            );
    }
    else
         $data = array();

    $form_builder = $app['form.factory']->createBuilder('form', $data)
    ->add('name','text', array(
        'label' => 'Module Class name',
        'attr' => array ('placeholder' => 'MyModuleClassName'),
        'constraints' => array(
         new Assert\NotBlank(),
         // @todo assert is a regular class name
         )
      )			
    )
    ->add('displayName')
    ->add('description')
    ->add('author')
    ->add('tab', 'choice', array('choices' => $app['PrestashopModuleGenerator']::getTabs() ))
    ->add('need_instance', 'checkbox', array('required' => false))
    ->add('version' , 'text', array ('attr' => array('placeholder' => '0.1') ) );

    // hooks
    $hooks_builder = $app['form.factory']->createBuilder('form', null, array('label' => 'Hooks' /*, 'block_name' => 'myname1'*/ ));

    foreach($app['PrestashopModuleGenerator']::getHooks() AS $hook)
    {
        $hooks_builder->add($hook['name'], 'checkbox', array('label' => $hook['name'],'required' => false )) ;
    }
    // insert hooks into main form builder
    $form_builder->add($hooks_builder);

    // has a configuration form in admin ?
    $form_builder->add('has_config', 'checkbox', 
        array(  'label' => 'Admin page',
                'required' => false,
            ));
    
    // enable / disable functions ?
    $form_builder->add('enable_disable', 'checkbox', 
        array(  'label' => 'enable / disable functions',
                'required' => false,
            ));
    
    // installDb / uninstallDb functions ?
    $form_builder->add('install_uninstall_db', 'checkbox', 
        array(  'label' => 'install / uninstall Db functions',
                'required' => false,
            ));
    
    // generate button
    $form_builder->add('generate', 'submit', array('label' => 'Generate' /*,'attr' => array('class' => 'pure-button')*/ ));

    $form = $form_builder->getForm();
    $form->handleRequest($request);

    if ($form->isValid()) 
    {
        $data = $form->getData();
        $module_class_code = $app['PrestashopModuleGenerator']->generate($data);

        // output result to a file, for debuging
        if(defined('DEBUG_TO_FILE') && DEBUG_TO_FILE)
            file_put_contents(DEBUG_TO_FILE, $module_class_code);

        // highlight code and output
        $module_class_code = $app['highlighter']->setLexer(new \FSHL\Lexer\Php())->highlight($module_class_code);
        $page = $app['twig']->render('module.html.twig', array('module_class_code' => $module_class_code));

        return $page;
    }

    // display the form
    return $app['twig']->render('form.html.twig', array('form' => $form->createView()));
});

// clear twig cache (needed in production when template changed)
$app->get('/clear-cache/{clear_cache_key}', function ($clear_cache_key) use ($app) {
   if(isset($app['twig.options']['clear_cache_key']) && $clear_cache_key === $app['twig.options']['clear_cache_key'])
   {
       $app['twig']->clearCacheFiles();
       return new Response('cache cleared') ;
   }
   else
        return new Response($app['twig']->render('errors/404.html'));
});

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html',
        'errors/'.substr($code, 0, 2).'x.html',
        'errors/'.substr($code, 0, 1).'xx.html',
        'errors/default.html',
        );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
