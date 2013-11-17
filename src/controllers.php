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

$app['PrestashopModuleGenerator'] = function() { return new PrestashopModuleGenerator(); };

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html', array());
})
->bind('homepage')
;

$app->match('/form', function(Request $request) use($app) 
{
// some default data for when the form is displayed the first time
    $data = array(
        'name' => 'Your name',
        'email' => 'Your email',
        );

    $form = $app['form.factory']->createBuilder('form', $data)
    ->add('name','text', array(
      'constraints' => array(
         new Assert\NotBlank()
         )
      )			
    )
    ->add('email')
    ->add('gender', 'choice', array(
        'choices' => array(1 => 'male', 2 => 'female'),
        'expanded' => true,
        ))
    ->add('save', 'submit')
    ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) 
    {
        $data = $form->getData();

        // do something with the data
        // var_dump($data);

        
        $res = $app['PrestashopModuleGenerator']->generate($data);
        var_dump($res);

        // redirect somewhere
        return 'Redirect to implement';
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
