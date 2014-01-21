<?php
/**
 * Main app
 * 
 * @package Prestahop Module builder
 * @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
 * @link https://github.com/SebSept/PrestashopModuleBuilder
 */

// register PrestashopModuleGenerator in composer loader
$loader->add('PrestashopModuleGenerator', __DIR__ . '/../src/');

// create app
$app = new \Slim\Slim($config['slim']);

// injections 
// twig
$TwigLoader = new Twig_Loader_Filesystem();
$TwigLoader->setPaths( $config['twig']['path'] );
$app->twig = new Twig_Environment($TwigLoader, $config['twig']['options']);
$app->twig->addGlobal('base_url', $app->environment['slim.url_scheme'] . '://' . $app->environment['HTTP_HOST'] . $app->environment['SCRIPT_NAME'] . '/');

// csrfp
$signer = new Kunststube\CSRFP\SignatureGenerator('c553afae47c9c53d4c0f47a0bf0d0d977fd773f9');
$app->signer = $signer;

// psmodulegenerator
$app->psmodgen = new PrestashopModuleGenerator($app->twig);

//highlighter
$app->highlighter = new \FSHL\Highlighter(new \FSHL\Output\Html());
$app->highlighter->setLexer(new \FSHL\Lexer\Php());

// cache component (file cache)
$app->cache = new \SebSept\SimpleFileCache\Cache( 
        array(
            'directoryPath' => $config['cache']['directoryPath'],
            'delay' => $config['cache']['delay']
            ) 
        
        );

// time spent displayed in debug mode
if($app->getMode() == 'development')
{
    $loader->add('Chrono', __DIR__ . '/../src/');
    $app->add(new Chrono);
}

// app routes and controllers

/**
 * / home 
 */
$app->get('/', function () use ($app) {
    if(!$data = $app->cache->get('home') )
    {
        $data = $app->twig->render('index.html.twig');
        $app->cache->set('home', $data);
    }
    echo $data;
});

/**
 * /form
 * form displayed (GET)
 */
$app->get('/form', function () use ($app) {
    if(!$data = $app->cache->get('form'))
    {
        if($app->getMode() == 'development')
        {
            $data = array(
                'tabs' => $app->psmodgen->getTabs(),
                'hooks' => $app->psmodgen->getHooks(),
                'need_instance' => false,
                'version' => '0.1',
                'classname' => 'MyModule',
                'displayname' => 'My module to foo',
                'description' => 'adds a bar on each fu',
                'author' => 'Module man'
                );
        }
        else
            $data = array(
                'tabs' => $app->psmodgen->getTabs(),
                'hooks' => $app->psmodgen->getHooks()
                );

        $data = $app->twig->render('form.html.twig', $data );

        //write to cache
        $app->cache->set('form', $data);
    }
    echo $data;
});

/**
 * form
 * form submitted (POST)
 */
$app->post('/form', function () use ($app) {
    if (isset($_POST['generate']) && $app->signer->validateSignature($_POST['_token'])) 
    {
        $app->psmodgen->setData($_POST);
        $module_class_code = $app->psmodgen->getMainCode();

        // output result to a file, for debuging
        if($app->config('debugtofile') && $app->getMode() === 'development')
            file_put_contents($app->config('debugtofile'), $module_class_code);

        // highlight code and output
        $module_class_code = $app->highlighter->highlight($module_class_code);
        echo $app->twig->render('module.html.twig', array('module_class_code' => $module_class_code));
    } 
    else 
    {
        echo 'invalid csrfp signature';
    }
});

/**
 * /csrfp
 * csrfp signature
 */
$app->get('/csrfp', function () use ($app) {
    echo json_encode(array('csrfp' => htmlspecialchars($app->signer->getSignature())));
});


/**
 * Action!
 */
$app->run();
