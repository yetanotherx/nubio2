<?php 

use_helper('Text');

$header = sprintf( 'Viewing source for topic #%s (%s)', $nubio_topic->getId(), truncate_text( $nubio_topic->getSummary() ) );

slot( 'title', $header . ' | Nubio' );
slot( 'header', $header );

?>

<h2>Question: <?php echo $nubio_topic->getSummary() ?></h2>


<p>
<pre>
<?php echo $nubio_topic->obtainReference('NubioRevision')->getText() ?>
</pre>
</p>

<hr />

<ul>
	<li><?php echo link_to('Back to topic', 'topic/show?id=' . $nubio_topic->getId()) ?></li>
    <li><?php echo link_to('Back to topic index', 'topic/index') ?></li>
</ul>
