<?php

use_helper('Text');
use_helper('Nubio');

$nubio_guard = $nubio_helper->obtainReference('sfGuardUser');

$pretty_username = Nubio::parsePrettyUsername( $nubio_helper, $nubio_guard );

$header = sprintf( 'User #%s - %s', $nubio_helper->getId(), $pretty_username );
slot( 'title', $header . ' | Nubio' );
slot( 'header', $header );

?>

<table class="prettytable" width="100%">
  <tbody>
    <tr>
      <th>Username:</th>
      <td><?php echo $nubio_guard->getUsername() ?></td>
    </tr>
    <tr>
      <th>Wikipedia username:</th>
      <td><?php echo wikiLink( $nubio_helper->getWikiname(), 'User:' . $nubio_helper->getWikiname() ) ?></td>
    </tr>
    <tr>
      <th>User groups:</th>
      <td><?php echo ( $nubio_guard->getIsSuperAdmin() ) ? 'Administrator' : ''; ?></td>
    </tr>
    <?php
	if( $sf_user->isSuperAdmin()) {
		echo '<th>Active?</th>';
		echo '<td>' . ( ( $nubio_guard->getIsActive() ) ? 'Yes' : 'No' ) . '</td>';
	}
	?>
    <tr>
      <th>Approved?</th>
      <td><?php echo ( $nubio_helper->getIsApproved() ) ? 'Yes' : 'No'; ?></td>
    </tr>
    <tr>
      <th>Blocked?</th>
      <td><?php echo ( $nubio_helper->getIsBlocked() ) ? 'Yes' : 'No'; ?></td>
    </tr>
    <tr>
      <th>Registration:</th>
      <td><?php echo $nubio_guard->getCreatedAt() ?></td>
    </tr>
  </tbody>
</table>

<ul>
<?php

if( $sf_user->isAuthenticated() && $nubio_guard->getId() == $sf_user->getGuardUser()->getId() ) {
	echo '<li>' . link_to('Account settings', 'userreg/edit?id=' . $nubio_helper->getId()) . '</li>'; 
}
echo '<li>' . link_to('User contributions', '@user_contribs_username?id=' . $nubio_helper->getId()) . '</li>';
echo '<li>' . link_to('Back to the user list', '@user') . '</li>'; 
echo '<li>' . link_to('Back to the homepage', '@homepage') . '</li>'; 


?>
</ul>