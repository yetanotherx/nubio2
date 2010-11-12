<?php 

use_helper('Text');

$nubio_topic = Doctrine_Core::getTable('NubioTopic')->getTopicFromID( $nubio_revision->getTopicID() );

$header = sprintf( 
	'Revision #%s to topic #%s - %s', 
	$nubio_revision->getId(), 
	$nubio_topic->getId(), 
	truncate_text( $nubio_topic->getSummary() )
);

slot( 'title', sprintf( '%s | Nubio', $header ) );
slot( 'header', $header );

?>

<table class="prettytable">
  <tbody>
    <tr>
      <th>Category:</th>
      <td><?php echo link_to( 
      	$nubio_topic->obtainReference('NubioCategory')->getName(), 
      	'NubioCategory', 
      	$nubio_topic->obtainReference('NubioCategory')
      ) ?></td>
    </tr>
    <tr>
      <th>Question:</th>
      <td><?php echo $nubio_topic->getSummary() ?></td>
    </tr>
    <tr>
      <th>Answer:</th>
      <td><?php echo $nubio_topic->obtainReference('NubioRevision')->getText() ?></td>
    </tr>
    <tr>
      <th>Keywords:</th>
      <td><?php echo $nubio_topic->getKeywords() ?></td>
    </tr>
    <tr>
      <th>Timestamp:</th>
      <td><?php echo $nubio_topic->obtainReference('NubioRevision')->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Username:</th>
      <td><?php echo link_to( 
      	$nubio_topic->obtainReference('NubioRevision')->obtainReference('NubioHelper')->obtainReference('sfGuardUser')->getUsername(),
      	'user/show?id=' .
      	$nubio_topic->obtainReference('NubioRevision')->obtainReference('NubioHelper')->getId() ) ?></td>
    </tr>
  </tbody>
</table>

<ul>
<li><?php echo link_to( 
	'Changes since previous revision', 
	'@revision_diff?oldid=' . $nubio_revision->getPreviousRevision() . '&id=' . $nubio_revision->getId() 
); ?></li>
<li><?php echo link_to( 
	'View all changes to this topic', 
	'@topic_id_history?id=' . $nubio_topic->getId() 
); ?></li>
<li><?php echo link_to( 
	'Go back to the topic page', 
	'topic/show?id=' . $nubio_topic->getId() 
); ?></li>
<li><?php
echo link_to('Go back to the homepage', '@homepage');
?></li>

</ul>