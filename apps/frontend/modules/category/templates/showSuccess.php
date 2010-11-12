<?php 

slot( 'title', sprintf( 'Topics in the %s category | Nubio', $nubio_category->getName() ) );
slot( 'header', sprintf( 'Category - %s', $nubio_category->getName() ) );

include_partial('topic/list', array('nubio_topics' => $category_pager->getResults(), 'nubio_category' => $nubio_category));

include_partial( 
	'global/paginaterfoot', 
	array( 
		'pager' => $category_pager,
		'text' => '%s topics in this category',
	) 
); 

echo link_to('Back to homepage', '@homepage'); 

?>