<?php

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

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html', array());
})
->bind('homepage')
;

$app->match('/form', function(Request $request) use($app) 
{
    // some default data for when the form is displayed the first time
    $data = array(
        'need_instance' => false,
        'version' => '0.1',
        // dev values
        'name' => 'MyModule',
        'displayName' => 'My module to foo',
        'description' => 'adds a bar on each fu',
        'author' => 'Module man'
        );


    $form_builder = $app['form.factory']->createBuilder('form', $data)
    ->add('name','text', array(
        'label' => 'Module Class name',
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
    ->add('version');

    // hooks
    $hooks_builder = $app['form.factory']->createBuilder('form', null, array('label' => 'Hooks' /*, 'block_name' => 'myname1'*/ ));

    foreach($app['PrestashopModuleGenerator']::getHooksListData() AS $hook)
    {
        $hooks_builder->add($hook, 'checkbox', array('label' => $hook,'required' => false )) ;
    }
    // insert hooks into main form builder
    $form_builder->add($hooks_builder);

    // has a configuration form in admin ?
    $form_builder->add('has_config', 'checkbox', 
        array(  'label' => 'Has an admin page ? (to change module parameters or content)',
                'required' => false,
            ));
    // save button
    $form_builder->add('save', 'submit');

    $form = $form_builder->getForm();
    $form->handleRequest($request);

    if ($form->isValid()) 
    {
        $data = $form->getData();
        // var_dump($data);
        // methode direct
        // $module_class_code = $app['twig']->render('module.php.twig', $data);
        
        // methode via PrestashopModuleGenerator
        $module_class_code = $app['PrestashopModuleGenerator']->generate($data);
        $page = $app['twig']->render('module.html', array('module_class_code' => $module_class_code));

        return $page;
        // return 'Redirect to implement';
        // return $app->redirect('...');
    }

    // display the form
    return $app['twig']->render('form.html', array('form' => $form->createView()));
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
