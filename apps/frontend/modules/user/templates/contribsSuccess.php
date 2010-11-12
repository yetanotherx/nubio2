<?php 

$header = 'User contributions by ' . $nubio_helper->obtainReference('sfGuardUser')->getUsername();
slot( 'title', $header . ' | Nubio' );
slot( 'header', $header );

use_helper('Text');

include_partial('revision/list', array('nubio_revisions' => $revision_pager->getResults()));

include_partial( 
	'global/paginaterfoot', 
	array( 
		'pager' => $revision_pager,
		'text' => '%s contributions by ' . $nubio_helper->obtainReference('sfGuardUser')->getUsername(),
	) 
); 

echo link_to('Back to ' . $nubio_helper->obtainReference('sfGuardUser')->getUsername() . "'s profile", '@user_username?id=' . $nubio_helper->getId()); 
