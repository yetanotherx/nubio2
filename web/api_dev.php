<?php

define( 'INITTIME', microtime(1) );
define( 'MEDIAWIKI', 1 );

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('api', 'dev', true);

if ( !in_array( md5( (string) @$_SERVER['REMOTE_ADDR'] ), $allowed_ips ) ) {
  die('Hey! Get outta here! This area\'s private, dontchaknow!');
}

$GLOBALS['IP'] = $IP = dirname(__FILE__) . '/api';
require_once( "$IP/includes/ProfilerStub.php" );
require_once( "$IP/includes/Defines.php" );
require_once( "$IP/includes/DefaultSettings.php" );
require_once( "$IP/includes/AutoLoader.php" );
require_once( "$IP/includes/Setup.php" );

sfContext::createInstance($configuration)->dispatch();
