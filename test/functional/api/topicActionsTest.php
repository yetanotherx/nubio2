<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new NubioTestFunctional(new sfBrowser());
$browser->loadData();

$browser->
  get('/php/topic')->

  with('request')->begin()->
    isParameter('module', 'topic')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;
