<?php 

use_helper('Text');

$header = sprintf( 'Search results for "%s"', truncate_text( $sf_request->getParameter('query') ) );
slot( 'title', $header . ' | Nubio' );
slot( 'header', $header );

include_partial( 'topic/list', array( 'nubio_topics' => $nubio_topics ) );
