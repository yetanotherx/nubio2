<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

require_once(dirname(__FILE__).'/../config/PrivateConfiguration.class.php');

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineGuardPlugin');
    $this->enablePlugins('sfDoctrineApplyPlugin');
    $this->enablePlugins('omCrossAppUrlPlugin');
    $this->enablePlugins('sfNubioAddonFunctionsPlugin');
    
    $this->dispatcher->connect('debug.web.load_panels', array(
    	'acWebDebugPanelAPI',
    	'listenToLoadDebugWebPanelEvent'
  	));
  	
  	PrivateConfiguration::setup();
    $this->enablePlugins('sfTaskExtraPlugin');
  }
  
  static protected $zendLoaded = false;
 
  static public function registerZend()
  {
    if (self::$zendLoaded)
    {
      return;
    }
 
    set_include_path(sfConfig::get('sf_lib_dir').'/vendor'.PATH_SEPARATOR.get_include_path());
    require_once sfConfig::get('sf_lib_dir').'/vendor/Zend/Loader/Autoloader.php';
    Zend_Loader_Autoloader::getInstance();
    self::$zendLoaded = true;

  }

}
