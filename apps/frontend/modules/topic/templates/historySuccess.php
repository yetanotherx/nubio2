<?php 

use_helper('Text');

$header = sprintf( 'Revision history of #%s (%s)', $nubio_topic->getId(), truncate_text( $nubio_topic->getSummary() ) );

slot( 'title', $header . ' | Nubio' );
slot( 'header', $header );

include_partial('revision/list', array('nubio_revisions' => $revision_pager->getResults()));

include_partial( 
	'global/paginaterfoot', 
	array( 
		'pager' => $revision_pager,
		'text' => '%s edit(s) to topic ' . sprintf( '#%s (%s)', $nubio_topic->getId(), $nubio_topic->getSummary() ),
	) 
); 

echo link_to( 'Back to topic', 'topic/show?id=' . $nubio_topic->getId() ); 

