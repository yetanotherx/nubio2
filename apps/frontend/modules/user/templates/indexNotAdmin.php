<?php 

slot( 'title', 'Error | Nubio' );
slot( 'header', 'Error' );

use_helper('Text');

?>
<p>
You must be an administrator to be able to view only unapproved accounts.
</p>

<?php echo link_to('Back to the homepage', '@homepage');  ?>
