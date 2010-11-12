<?php 

slot( 'title', 'Recent changes | Nubio' );
slot( 'header', 'Recent changes to Nubio' );

use_helper('Text');

include_partial('revision/list', array('nubio_revisions' => $revision_pager->getResults()));

include_partial( 
	'global/paginaterfoot', 
	array( 
		'pager' => $revision_pager,
		'text' => '%s total revisions',
	) 
); 

echo link_to('Back to the homepage', '@homepage'); 

