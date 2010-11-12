<?php 

use_helper('Text');

$nubio_topic = $form->getObject();

$header = sprintf( 'Editing topic #%s (%s)', $nubio_topic->getId(), truncate_text( $nubio_topic->getSummary() ) );
slot( 'title', $header . ' | Nubio' );
slot( 'header', $header );

include_partial( 'form', array('form' => $form) );
