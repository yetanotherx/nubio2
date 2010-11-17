<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$cat_index_arr = array(
	'query' => array(
		'result' => array(
			array(
				'id' => '1',
				'name' => 'General'
			),
			array(
				'id' => '2',
				'name' => 'Wikitext'
			)
		)
	)
);

$cat_show_arr = array(
	'query' => array(
		'result' => array(
			'id' => '1',
			'name' => 'General'
		)
	)
);

$browser = new NubioTestFunctional(new sfBrowser());
$browser->loadData();

$browser->
  get('/php/category/')->

  with('request')->begin()->
    isParameter('module', 'category')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/' . preg_quote(serialize( $cat_index_arr ), '/') . '/' )->
  end()->
  
  get('/php/category/show/1')->

  with('request')->begin()->
    isParameter('module', 'category')->
    isParameter('action', 'show')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/' . preg_quote(serialize( $cat_show_arr ), '/') . '/' )->
  end()
;
