<?php 

slot( 'title', 'User list | Nubio' );
slot( 'header', 'Nubio user list' );

use_helper('Text');

?>

<table class="prettytable">
	<thead>
		<tr>
		<th>#</th>
		<th>Username</th>
		<th>Wikipedia username</th>
		<th>Registered</th>
		<th>Groups</th>
		<th>Blocked?</th>
		<?php
		if( $sf_user->isSuperAdmin()) {
			echo '<th>Is approved?</th>';
			echo '<th>Approve</th>';
		}
		?>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $helper_pager->getResults() as $nubio_helper ): ?>
		
		<?php
			$nubio_guard = $nubio_helper->obtainReference('sfGuardUser');
			$pretty_title = Nubio::parsePrettyUsername( $nubio_helper, $nubio_guard );
		?>
		<tr>
			<td><?php echo link_to( $nubio_helper->getId(), 'user/show?id='.$nubio_helper->getId() ) ?></td>
			<td><?php echo $pretty_title ?></td>
			<td><?php echo $nubio_helper->getWikiname() ?></td>
			<td><?php echo $nubio_helper->getCreatedAt(); ?></td>
			<td><?php echo ( $nubio_helper->obtainReference('sfGuardUser')->getIsSuperAdmin() ) ? 'Administrator' : ''?></td>
			<td><?php echo ( $nubio_helper->getIsBlocked() ) ? 'Yes' : 'No' ?></td>
			<?php
			if( $sf_user->isSuperAdmin()) {
				echo '<td>'. $nubio_helper->getIsApproved() .'</td>';
				if( !$nubio_helper->getIsApproved() ) {
					echo '<td>'. link_to( 'Approve', '@userreg_approve?id=' . $nubio_helper->getId() ) .'</td>';
				}
				else {
					echo '<td></td>';
				}
				
			}
			?>
		</tr>
	</tbody>

		<?php endforeach; ?>
</table>

<?php
include_partial( 
	'global/paginaterfoot', 
	array( 
		'pager' => $helper_pager,
		'text' => '%s total users',
	) 
); 

echo link_to('Back to the homepage', '@homepage'); 

