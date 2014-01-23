<?php
/**
* PrestashopModuleGenerator 
*
* To create Prestashop Module files skeleton 
* 
* @author sebastienmonterisi@yahoo.fr
* @todo uncouple from parser and template engine
**/

//use Symfony\Component\Yaml\Parser;

class PrestashopModuleGenerator
{
	//protected $template;
	
	/*
	* @var Twig_Environement Twig environement instance
	*/
	private $twig;

	/**
	* @var $configFile string Path to yaml config file
	**/
	protected static $configFile = '/../config/PrestashopModuleGeneratorConfig.yml';

	/**
	* @var $hooks array Prestashop hooks [ ([name],[title],[description]), () ...]
	**/
	protected static $hooks = array();

	/**
	* @var $config array PrestashopModuleGenerator configurations datas (hooks, tabs)
	**/
	protected static $config = array();

	/**
	* @var $tabs array Prestashop admin tabs [ [id],... ]
	**/
	protected static $tabs = array();
        
	public function __construct($twig)
	{
		$filter = new Twig_SimpleFilter('ucfirst', 'ucfirst');
		$this->twig = $twig;
		$this->twig->addFilter($filter);
	}

	/**
	*
	* @return mixed bool|string False if failled, url to generated file if success
	*/
	public function getMainCode()
	{
		return $this->twig->render('module.php.twig', $this->data);
	}

        /**
         * Receive raw data
         * 
         * Since twig filter the datas, they are not filtered
         * If later you use another template engine, you may need to sanitize input datas
         * 
         * @param type $data
         * @return void
         */
        public function setData($data)
        {
            $this->data = $data;
            // replace 'hooks' from form with hooks from config (to get description data)
            if(!empty($this->data['hooks']))
            {
                $_hooks = $this->getHooks();
                foreach($this->data['hooks'] AS $hook => $on)
                {
                    $this->data['hooks'][$hook] = $_hooks[$hook];
                }
            }
        }
        
	/**
	* Prestashop Hooks
	*
	* @return Array Prestashop hooks [ [name] => ([name],[title],[description]), () ...]
	*/
	public static function getHooks()
	{
	 	if(empty(self::$hooks))
	 	{
	 		$cfg = self::getConfig();
	 		self::$hooks = array_combine( array_column($cfg['hooks'], 'name'), $cfg['hooks']);
	 	}
	 	return self::$hooks;
	}

	/**
	* Prestashop Hooks
	*
	* @return Array Prestashop module admin tabs [ [name] => [name], ...]
	*/
	public static function getTabs()
	{
	 	if(empty(self::$tabs))
	 	{
	 		$cfg = self::getConfig();
	 		self::$tabs = array_combine( $cfg['tabs'], $cfg['tabs']) ;
	 	}
	 	return self::$tabs;
	}

        /**
         * Configuration (hooks and tabs)
         * 
         * @return array config values from yaml config file
         */
	protected static function getConfig()
	{
		if(empty(self::$config))
		{
			self::$config = (new Symfony\Component\Yaml\Parser())->parse(file_get_contents(__DIR__.self::$configFile));
		}
		return self::$config;
	}
}
