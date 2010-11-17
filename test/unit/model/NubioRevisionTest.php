<?php

include(dirname(__FILE__).'/../../bootstrap/doctrine.php');
 
$t = new NubioUnitTest();


$revision = Doctrine_Core::getTable('NubioRevision')->createBaseQuery()->fetchOne();
$table = Doctrine_Core::getTable('NubioRevision');

$rev2 = new NubioRevision();
$rev2->helper_id = 1;
$rev2->topic_id = 5;
$rev2->text = 'fwfw';
$rev2->comment = 'wrgfkjs';
$rev2->save();

$t->info( '1 - ::getPreviousRevision()' );

$t->is( $rev2->getPreviousRevision(), 5, '::getPreviousRevision() returns its previous revision' );

$t->is( $revision->getPreviousRevision(), 1, '::getPreviousRevision() returns its own revision if first' );
