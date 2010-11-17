<?php

include(dirname(__FILE__).'/../../bootstrap/doctrine.php');
 
$t = new NubioUnitTest();



$category = Doctrine_Core::getTable('NubioCategory');


$t->info( '1 - ::getCategoryList()' );

$t->is( array_keys($category->getCategoryList()->toArray()), array( 0, 1 ), '::getCategoryList() returns only two categories' );

$t->info( '2 - ::getTopicListFromID()' );

$t->is( $category->getTopicListFromID( 1 )->count(), 13, '::getTopicListFromID( (General) ) returns 13 topics' );
$t->is( $category->getTopicListFromID( 2 )->count(), 1, '::getTopicListFromID( (Wikitext) ) returns 1 topics' );
$t->is( $category->getTopicListFromID( 3 )->count(), 0, '::getTopicListFromID( (Invalid) ) fails gracefully' );

$t->info( '3 - ::fetchFormArray()' );
$t->is( $category->fetchFormArray(), array( 1 => 'General', 2 => 'Wikitext' ), '::fetchFormArray() sets the proper keys' );

$t->info( '4 - ::getTopicsFromID()' );
$t->is( $category->getTopicsFromID( 1 )->count(), 10, '::getTopicsFromID() returns max 10 entries' );
$t->is( $category->getTopicsFromID( 1, 5 )->count(), 5, '::getTopicsFromID( int, 5) returns 5 entries' );
$t->is( $category->getTopicsFromID( 2, 5 )->count(), 1, '::getTopicsFromID( int, 5) returns max 5 entries when less than 5 actual entries' );
