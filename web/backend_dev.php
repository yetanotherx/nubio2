<?php

define( 'INITTIME', microtime(1) );

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('backend', 'dev', true);

if ( !in_array( md5( (string) @$_SERVER['REMOTE_ADDR'] ), $allowed_ips ) ) {
  die('Hey! Get outta here! This area\'s private, dontchaknow!');
}

sfContext::createInstance($configuration)->dispatch();
