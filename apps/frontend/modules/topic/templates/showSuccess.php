<?php 

use_helper('Text');

$header = sprintf( 'Topic #%s (%s)', $nubio_topic->getId(), truncate_text( $nubio_topic->getSummary() ) );

slot( 'title', $header . ' | Nubio' );
slot( 'header', $header );

?>

<h2>Question: <?php echo $nubio_topic->getSummary() ?></h2>


<p>
<?php echo Nubio::parseText( $nubio_topic->obtainReference('NubioRevision')->getText() ) ?>
</p>

<hr />

<ul>
	<li>Keywords: <?php echo $nubio_topic->getKeywords() ?></li>
	<li>Category: <?php echo link_to($nubio_topic->obtainReference('NubioCategory')->getName(), 'category_id', $nubio_topic->obtainReference('NubioCategory')) ?></li>
    <li>Last edited at <?php echo $nubio_topic->obtainReference('NubioRevision')->getUpdatedAt() ?> by <?php echo link_to( $nubio_topic->obtainReference('NubioRevision')->obtainReference('NubioHelper')->obtainReference('sfGuardUser')->getUsername(), '@user_username?id=' . $nubio_topic->obtainReference('NubioRevision')->obtainReference('NubioHelper')->getId() ); ?></li>
    <li>
    	<?php 
    	if ($sf_user->isAuthenticated()) {
    		echo link_to('Edit', 'topic_edit', $nubio_topic) . ' &middot; ';
    	}
    	else {
    		echo link_to( 'View source', 'topic/source?id=' . $nubio_topic->getId() ) . ' &middot; ';
    	}
    	echo link_to( 'History', '@topic_id_history?id=' . $nubio_topic->getId() );
    	?>
    </li>
    <li><?php echo link_to('Back to topic index', '@homepage') ?></li>
</ul>
