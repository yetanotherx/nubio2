<?php

$nubio_topics = Doctrine::getTable('NubioTopic')->createBaseQuery()->fetchArray();

?>

<table class="prettytable">
	<thead>
		<tr>
		<th>#</th>
		<th>Topic (id)</th>
		<th>Date</th>
		<th>Username</th>
		<th>Comment</th>
		<th>Links</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $nubio_revisions as $nubio_revision ): ?>
		<?php
			$nubio_topic = $nubio_topics[$nubio_revision->getTopicId()-1];
		?>
		<tr>
			<td><?php echo link_to( $nubio_revision->getId(), 'revision/show?id='.$nubio_revision->getId() ) ?></td>
			<td><?php echo link_to( sprintf( '%s (%s)', $nubio_topic['summary'], $nubio_topic['id'] ), 'topic/show?id='.$nubio_topic['id'] ) ?></td>
			<td><?php echo $nubio_revision->getCreatedAt() ?></td>
			<td><?php echo link_to( $nubio_topic['NubioRevision']['NubioHelper']['sfGuardUser']['username'], '@user_username?id=' . $nubio_topic['NubioRevision']['NubioHelper']['sfGuardUser']['id'] ); ?></td>
			<td><?php echo $nubio_revision->getComment() ?></td>
			<td><?php echo sprintf(
				'%s / %s',
				link_to( 
					'diff', 
					'@revision_diff?oldid=' . $nubio_revision->getPreviousRevision() . '&id=' . $nubio_revision->getId() 
				),
				link_to( 
					'history', 
					'@topic_id_history?id=' . $nubio_topic['id'] 
				)
			); ?></td>
		</tr>
	</tbody>

		<?php endforeach; ?>
</table>