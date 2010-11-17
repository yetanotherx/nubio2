<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new NubioTestFunctional(new sfBrowser());
$browser->loadData();

$browser->
  get('/category/index')->
  
  with('request')->begin()->
    isParameter('module', 'category')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
  	isForwardedTo('sfGuardAuth', 'signin')->
    isStatusCode(401)->
    checkElement('body', '!/This is a temporary page/')->
  end()->
  
  signin( 'admin', 'password' )->
  
  get('/category/index')->
  
  with('request')->begin()->
    isParameter('module', 'category')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
  	debug()->
  	isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;