<?php 

use_helper('Text');

slot( 'title', 'Topic List | Nubio' );
slot( 'header', 'Welcome to Nubio!' );

foreach( $category_pager->getResults() as $nubio_category) {
	$nubio_topics = $nubio_category->getTopicsFromCategoryID( 
		$nubio_category->getId(), 
		sfConfig::get('app_max_topics_per_category_on_homepage') 
	); 
	
	if( !count( $nubio_topics ) ) continue;

	echo sprintf( '<h3>%s</h3>', link_to( $nubio_category, 'category', $nubio_category ) );
	
	include_partial('topic/list', array( 'nubio_topics' => $nubio_topics, 'nubio_category' => $nubio_category ) );

	$count = $nubio_category->getTopicCountFromCategoryID( $nubio_category->getId() ); 
	if ( ( $count - sfConfig::get('app_max_topics_per_category_on_homepage') ) > 0 ) {
		echo 'See ' . link_to($count, 'category', $nubio_category) . ' more...';
	}	
}

include_partial( 
	'global/paginaterfoot', 
	array( 
		'pager' => $category_pager,
		'text' => '%s total categories',
	) 
); 
