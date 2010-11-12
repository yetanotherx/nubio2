<table class="prettytable">
	<thead>
		<tr>
		<th>#</th>
		<th>Question</th>
		<th>Keywords</th>
		<th>Last edited</th>
		<th>By...</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $nubio_topics as $nubio_topic ): ?>
		<tr<?php if( isset( $nubio_category ) ) echo ' class="category_' . Nubio::slugify($nubio_category->getName()) . '"' ?>>
			<td><a href="<?php echo url_for('topic/show?id='.$nubio_topic->getId()) ?>"><?php echo $nubio_topic->getId() ?></a></td>
			<td><?php echo $nubio_topic->getSummary() ?></td>
			<td><?php echo $nubio_topic->getKeywords() ?></td>
			<td><?php echo $nubio_topic->obtainReference('NubioRevision')->getCreatedAt() ?></td>
			<td><?php echo $nubio_topic->obtainReference('NubioRevision')->obtainReference('NubioHelper')->obtainReference('sfGuardUser')->getUsername(); ?></td>
		</tr>
	</tbody>

		<?php endforeach; ?>
</table>