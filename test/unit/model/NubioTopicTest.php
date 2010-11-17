<?php

include(dirname(__FILE__).'/../../bootstrap/doctrine.php');
 
$t = new lime_test();

$t->info( '1 - Testing fields' );

$topic1 = Doctrine_Core::getTable('NubioTopic')->createBaseQuery()->fetchOne();

$t->is( $topic1->getSummary(), 'Article1', 'Topic ID 1 has correct summary' );
$t->is( $topic1->obtainReference('NubioRevision')->getText(), 'Text1', 'Topic ID 1 has correct revision' );
$t->is( $topic1->obtainReference('NubioRevision')->obtainReference('NubioHelper')->getWikiname(), 'Administrator', 'Topic ID 1 has correct helper' );
$t->is( $topic1->obtainReference('NubioRevision')->obtainReference('NubioHelper')->obtainReference('sfGuardUser')->getId(), $topic1->obtainReference('NubioRevision')->obtainReference('NubioHelper')->getId(), 'Topic ID 1 has correct guard user' );
$t->is( $topic1->obtainReference('NubioCategory')->getName(), 'General', 'Topic ID 1 has correct category' );
