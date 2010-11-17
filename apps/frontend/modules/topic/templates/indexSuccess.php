<?php 

use_helper('Text');

slot( 'title', 'Topic List | Nubio' );
slot( 'header', 'Welcome to Nubio!' );

foreach( $category_pager->getResults() as $nubio_category) {
	$nubio_topics = Doctrine_Core::getTable('NubioCategory')->getTopicsFromID( 
		$nubio_category->getId(), 
		sfConfig::get('app_max_topics_per_category_on_homepage') 
	); 
	
	if( !count( $nubio_topics ) ) continue;

	echo sprintf( '<h3>%s</h3>', link_to( $nubio_category, 'category_id', $nubio_category ) );
	
	echo '<div class="category_' . Nubio::slugify($nubio_category->getName()) . '">';
	
	include_partial('topic/list', array( 'nubio_topics' => $nubio_topics, 'nubio_category' => $nubio_category ) );

	$count = Doctrine_Core::getTable('NubioCategory')->getTopicCountFromID( $nubio_category->getId() ); 
	if ( ( $count - sfConfig::get('app_max_topics_per_category_on_homepage') ) > 0 ) {
		echo '<span class="more_topics">See ' . link_to($count, 'category_id', $nubio_category) . ' more...</span>';
	}
	
	echo '</div>';	
}

include_partial( 
	'global/paginaterfoot', 
	array( 
		'pager' => $category_pager,
		'text' => '%s total categories',
	) 
); 
