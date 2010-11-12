<?php

define( 'INITTIME', microtime(1) );

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

if (!in_array(@$_SERVER['REMOTE_ADDR'], $allowed_ips))
{
  die('Hey! Get outta here! This area\'s private, dontchaknow!');
}

$configuration = ProjectConfiguration::getApplicationConfiguration('backend', 'dev', true);
sfContext::createInstance($configuration)->dispatch();
