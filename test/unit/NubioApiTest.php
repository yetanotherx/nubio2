<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new NubioUnitTest();
$request = new NubioFauxRequest();


$t->info('1 - ::parseFormats()');
$request->setParameter('format', 'xmlfm');

$t->cmp_ok( NubioApi::parseFormats($request), '>=', 10, '::parseFormats() has over 10 formats');

$request->setParameter('format', 'nosuchformat');
$ret = NubioApi::parseFormats($request);
$t->is( $ret['nosuchformat'], $ret['xmlfm'], '::parseFormats() sets an invalid format to xmlfm');


$t->info('2 - ::clean_ElementVals()');

$arr = array(
	'this' => 'is',
	'an' => array(
		'with' => 'various',
		'subarrays',
		'with both key types',
		'_element' => 'key'
	),
	'_element' => 'key2'
);

$clean_arr = array(
	'this' => 'is',
	'an' => array(
		'with' => 'various',
		'subarrays',
		'with both key types'
	)
);

$t->is( NubioApi::clean_ElementVals( $arr, 'NewApiFormatXml' ), $arr, '::parseFormats() doesn\'t remove for xml formats');
$t->is( NubioApi::clean_ElementVals( $arr, 'NewApiFormatPhp' ), $clean_arr, '::parseFormats() does remove for non-xml formats');
