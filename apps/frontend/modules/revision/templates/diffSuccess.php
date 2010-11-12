<?php

use_helper('Text');

$old_nubio_topic = Doctrine_Core::getTable('NubioTopic')->getTopicFromID( $old_revision->getTopicID() );
$new_nubio_topic = Doctrine_Core::getTable('NubioTopic')->getTopicFromID( $new_revision->getTopicID() );

if( $old_nubio_topic->getId() != $new_nubio_topic->getId() ) {
	$header = sprintf( 'Difference between revisions %s and %s to topics %s (%s) and %s (%s)',
		$old_revision->getId(),
		$new_revision->getId(),
		$old_nubio_topic->getId(),
		truncate_text( $old_nubio_topic->getSummary() ),
		$new_nubio_topic->getId(),
		truncate_text( $new_nubio_topic->getSummary() )
	);
}
else {
	$nubio_topic = $old_nubio_topic;
	unset( $old_nubio_topic, $new_nubio_topic );
	
	$header = sprintf( 'Difference between revisions %s and %s to topic %s (%s)',
		$old_revision->getId(),
		$new_revision->getId(),
		$nubio_topic->getId(),
		truncate_text( $nubio_topic->getSummary() )
	);
}

$diff = Diff::load( 'dualview', $old_revision->getText(), $new_revision->getText() );

slot( 'title', $header );
slot( 'header', $header );

?>

<table class="prettytable">
	<thead>
		<tr>
			<th></th>
			<th><?php echo link_to( "Old revision - {$old_revision->getId()}", 'revision/show?id=' . $old_revision->getId() ) ?></th>
			<th><?php echo link_to( "New revision - {$new_revision->getId()}", 'revision/show?id=' . $new_revision->getId() ) ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>Date/User</th>
			<td><?php echo $old_revision->getCreatedAt() ?> by <?php echo $old_revision->obtainReference('NubioHelper')->obtainReference('sfGuardUser')->getUsername(); ?></td>
			<td><?php echo $new_revision->getCreatedAt() ?> by <?php echo $new_revision->obtainReference('NubioHelper')->obtainReference('sfGuardUser')->getUsername(); ?></td>
		</tr>
		<tr>
			<th>Comment</th>
			<td><?php echo $old_revision->getComment() ?></td>
			<td><?php echo $new_revision->getComment() ?></td>
		</tr>
		<tr>
			<th>Diff</th>
			<td><?php echo nl2br( $diff[0] ) ?></td>
			<td><?php echo nl2br( $diff[1] ) ?></td>
		</tr>
		<?php
		
		$old_props = unserialize( html_entity_decode( $old_revision->getProps() ) );
		$new_props = unserialize( html_entity_decode( $new_revision->getProps() ) );
		
		if( count( $old_props ) || count( $new_props ) ) {
			echo "<tr>
			<th>Properties changed</th>";
			
			echo "<td>";
			if( count( $old_props ) ) echo Nubio::parseProps( $old_props );
			echo "</td>";
			
			echo "<td>";
			if( count( $new_props ) ) echo Nubio::parseProps( $new_props );
			echo "</td>";
			
			echo "</tr>";
		}
		
		?>
	</tbody>
</table>

<?php

if( !isset( $nubio_topic ) ) {
	echo link_to('Back to old topic', 'topic/show?id=' . $old_nubio_topic->getId() ); 
	echo ' / ';
	echo link_to('Back to new topic', 'topic/show?id=' . $new_nubio_topic->getId() ); 
}
else {
	echo link_to('Back to topic', 'topic/show?id=' . $nubio_topic->getId() ); 
}
