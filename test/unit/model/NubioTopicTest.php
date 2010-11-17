<?php

include(dirname(__FILE__).'/../../bootstrap/doctrine.php');
 
$t = new NubioUnitTest();

$t->info( '1 - Testing fields' );

$topic1 = Doctrine_Core::getTable('NubioTopic')->createBaseQuery()->fetchOne();

$t->is( $topic1->getSummary(), 'Article1', 'Topic ID 1 has correct summary' );
$t->is( $topic1->obtainReference('NubioRevision')->getText(), 'Text1', 'Topic ID 1 has correct revision' );
$t->is( $topic1->obtainReference('NubioRevision')->obtainReference('NubioHelper')->getWikiname(), 'Administrator', 'Topic ID 1 has correct helper' );
$t->is( $topic1->obtainReference('NubioRevision')->obtainReference('NubioHelper')->obtainReference('sfGuardUser')->getId(), $topic1->obtainReference('NubioRevision')->obtainReference('NubioHelper')->getId(), 'Topic ID 1 has correct guard user' );
$t->is( $topic1->obtainReference('NubioCategory')->getName(), 'General', 'Topic ID 1 has correct category' );

$t->info( '2 - Random topic' );

$i = 1;
for( $j = 0; $j < 20; $j++ ) checkOK( $t, Nubio::getRandTopicID(), $i );

function checkOK( $t, $topic_id, &$i ) {
	$t->cmp_ok( $topic_id, '<=', 15, 'Less than 15 test #' . $i ); 
	$t->cmp_ok( $topic_id, '>', 0, 'Less than 15 test #' . $i );
	
	$i++;
	
}

$t->info( '3 - Nubio::parsePrettyUsername()' );
$t->is(
	Nubio::parsePrettyUsername( Doctrine_Core::getTable('NubioHelper')->createQuery('u')->where('u.id = ?', 1)->fetchOne(), Doctrine_Core::getTable('sfGuardUser')->createQuery('u')->where('u.id = ?', 1)->fetchOne() ), 
	'admin', 
	'::parsePrettyUsername() works with sfGuardUser instance'
);
