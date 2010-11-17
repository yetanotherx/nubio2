<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');
 
$browser = new NubioTestFunctional(new sfBrowser());
$browser->loadData();

$browser->
  get('/category/General')->

  with('request')->begin()->
    isParameter('module', 'category')->
    isParameter('action', 'show')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/Back to homepage/')->
    checkElement('body', '/13 topics in this category/')->
  end()
;
