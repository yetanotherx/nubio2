<?php

define( 'INITTIME', microtime(1) );

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
require_once(dirname(__FILE__).'/../config/PrivateConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);

if (!in_array(@$_SERVER['REMOTE_ADDR'], $allowed_ips))
{
  die('Hey! Get outta here! This area\'s private, dontchaknow!');
}

sfContext::createInstance($configuration)->dispatch();
