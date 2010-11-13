<?php

use_helper('Text');
slot( 'title', 'List of categories | Nubio' );
slot( 'header', 'Category list' );

?>

<table class="prettytable" width="100%">
	<thead>
		<tr>
		<th>#</th>
		<th>Name</th>
		<th># of topics</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $category_pager->getResults() as $nubio_category ): ?>
		<tr>
			<td><?php echo link_to( $nubio_category->getId(), '@category_id?id='.$nubio_category->getId() ) ?></td>
			<td><?php echo $nubio_category->getName() ?></td>
			<td><?php echo count( Doctrine_Core::getTable( 'NubioCategory' )->getTopicListFromID( $nubio_category->getId() ) ) ?></td>
		</tr>
	</tbody>

		<?php endforeach; ?>
</table>

<?php 
include_partial( 
	'global/paginaterfoot', 
	array( 
		'pager' => $category_pager,
		'text' => '%s total categories',
	) 
); 
?>
