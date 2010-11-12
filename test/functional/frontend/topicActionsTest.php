<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$max = sfConfig::get('app_max_topics_per_category_on_homepage');
 
$browser = new NubioTestFunctional(new sfBrowser());
$browser->loadData();
 
$browser->info('1 - The homepage')->
  get('/')->
  with('request')->begin()->
    isParameter('module', 'topic')->
    isParameter('action', 'index')->
  end()->
  with('response')->begin()->
    info(sprintf('  1.1 - Only %s topics are listed for a category', $max))->
	checkElement('.category_general tr', $max)->
    
  end()
;