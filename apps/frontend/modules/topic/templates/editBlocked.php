<?php 

use_helper('Text');

$header = sprintf( 'Editing topic #%s (%s)', $nubio_topic->getId(), truncate_text( $nubio_topic->getSummary() ) );
slot( 'title', $header . ' | Nubio' );
slot( 'header', $header );

?>

<p>
You are currently blocked. For more info, please ask in the #wikipedia-en-help channel on Freenode.net IRC
</p>