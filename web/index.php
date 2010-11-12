<?php

define( 'INITTIME', microtime(1) );

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
require_once(dirname(__FILE__).'/../config/PrivateConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);
sfContext::createInstance($configuration)->dispatch();
