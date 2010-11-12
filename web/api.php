<?php

define( 'INITTIME', microtime(1) );
define( 'MEDIAWIKI', 1 );

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
$IP = dirname(__FILE__) . '/api';
require_once( "$IP/includes/ProfilerStub.php" );
require_once( "$IP/includes/Defines.php" );
require_once( "$IP/includes/DefaultSettings.php" );
require_once( "$IP/includes/AutoLoader.php" );
require_once( "$IP/includes/Setup.php" );

$configuration = ProjectConfiguration::getApplicationConfiguration('api', 'prod', false);
sfContext::createInstance($configuration)->dispatch();
