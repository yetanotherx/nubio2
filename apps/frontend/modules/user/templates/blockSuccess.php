<?php 

$header = 'Block user';
slot( 'title', $header . ' | Nubio' );
slot( 'header', $header );

use_helper('Text');

echo $nubio_helper->obtainReference('sfGuardUser')->getUsername() . " has been blocked.<br /><br />";

echo link_to('Back to ' . $nubio_helper->obtainReference('sfGuardUser')->getUsername() . "'s profile", '@user_username?id=' . $nubio_helper->getId()); 
