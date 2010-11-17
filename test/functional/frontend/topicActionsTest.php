<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$max = sfConfig::get('app_max_topics_per_category_on_homepage') + 1;
 
$browser = new NubioTestFunctional(new sfBrowser());
$browser->loadData();

$browser->info('1 - The homepage')->
  get('/')->
  with('request')->begin()->
    isParameter('module', 'topic')->
    isParameter('action', 'index')->
  end()->
  with('response')->begin()->
    info(sprintf('1.1 - Only %s topics are listed for a category', $max))->
	checkElement('.category_general tr', $max)->
    //debug()->
  info('1.2 - A category has a link to the category page only if too many topics')->
	checkElement('.category_wikitext .more_topics', false)->
    checkElement('.category_general .more_topics')->

end();
	
$topic2 = Doctrine_Core::getTable('NubioTopic')->getTopicFromID( 2 );

$browser->info('2 - The topic page')->
  
  info('2.1 - Each topic on the homepage is clickable and give detailed information')->
  click('2')->
  with('request')->begin()->
    isParameter('module', 'topic')->
    isParameter('action', 'show')->
    isParameter('id', $topic2->getId())->
  end()
;
