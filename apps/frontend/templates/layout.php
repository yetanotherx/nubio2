<?php

use_helper( 'Number' );
use_helper( 'I18N' );
use_helper( 'Text' );

use_javascript('jquery-1.4.3.min.js');
use_javascript('search.js');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<?php include_http_metas() ?>
    <?php include_metas() ?>
	<link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
	<title><?php include_slot('title', 'Nubio') ?></title>
</head>

<body>
	<div class="wrapper">
		<div class="header_bar">
			<span style="font-size:125%;"><a href="<?php echo url_for('homepage') ?>" style="text-decoration:none;"><span style="color:#fff;">Nubio</span></a></span> &middot; 
			<a href="#">Bugs</a> &middot; 
			<a href="#">Twitter</a>
		</div>
		<div class="main_content">
			<form action="<?php echo url_for('topic_search') ?>" method="get">
  				
  				<h2 class="teal head search" style="text-align:center; margin:0px auto;">
  					Search: <input type="text" style="width:75%;" name="query" value="<?php echo $sf_request->getParameter('query') ?>" id="search_bar" />
  					<input type="submit" value="search" /><img id="loader" src="<?php echo image_path( 'Ajax-loader.gif' ) ?>" style="vertical-align: middle; display:none;" />
</h2>
</form>

			<table class="content_table" style="width:100%;">
				<tr>
					<td class="content_box main_box">
						<h2 class="green head"><?php include_slot('header', 'Nubio') ?></h2>
						
						<?php if ($sf_user->hasFlash('notice')): ?>
<h2 class="teal head"><?php echo $sf_user->getFlash('notice') ?></h2>
						<?php endif; ?>
						
						<?php if ($sf_user->hasFlash('error')): ?>
<h2 class="red head"><?php echo $sf_user->getFlash('error') ?></h2>
						<?php endif; ?>
						
						<div id="sf_content"><?php echo $sf_content ?></div>
						
						<hr />
						<?php echo "Executed in " . number_format( ( microtime(1) - INITTIME ), 2 ) . " seconds"; ?>
					</td>
					<td class="content_box nav_box">
						<h2 class="green head">Navigation</h2>
						<ul>
							<li><?php echo link_to( 'Homepage', '@homepage' ) ?></li>
							<li><?php echo link_to( 'Categories', '@category_index' ) ?></li>
							<ul>
								<?php
								$cat_num = 1;
								foreach( Doctrine_Core::getTable( 'NubioCategory' )->getCategoryList() as $category ) {
									if( $cat_num > sfConfig::get( 'app_max_categories_on_sidebar' ) ) {
										//echo link_to( 'See more...', 'category/list' );
										break;
									}
									echo sprintf( '<li>%s</li>', link_to($category, 'category_id', $category) );
									$cat_num++;
								}
								
								?>
							</ul>
							
							<li><?php echo link_to( 'Random question', '@topic_random' ) ?></li>
							<li><?php echo link_to( 'Recent Changes', '@revision' ) ?></li>
							<li><?php echo link_to( 'User list', '@user' ) ?></li>
							<li>API</li>
							<?php 
								if ($sf_user->isAuthenticated()) {
									echo '<li>' . link_to('New topic', 'topic/new') . '</li>';
									echo '<li>' . link_to('Logout', 'sf_guard_signout') . '</li>';
									echo '<li>' . link_to('My account', '@user_username?id=' . $sf_user->getGuardUser()->getId()) . '</li>';
									//echo '<li>' . link_to('Users', 'sf_guard_user')  . '</li>';
									if( $sf_user->isSuperAdmin()) {
										echo '<li>Admin area</li>';
										echo '<li>' . link_to('Unapproved users', '@user?onlyunapproved=true' ) . '</li>';
									}
								}
								else { 
									echo '<li>' . link_to('Login', 'sf_guard_signin') . '</li>'; 
									echo '<li>' . link_to("Create Account", "userreg_new") . '</li>';
								} ?>
						</ul>
						
						<h2 class="green head">Recently viewed</h2>
						<ul>
    					<?php foreach ($sf_user->getTopicHistory() as $topic): ?>
      						<li>
       						<?php echo link_to($topic['id'].' - '. truncate_text( $topic['summary'] ), 'topic/show?id=' . $topic['id']) ?>
      						</li>
						<?php endforeach ?>
						</ul>
	

					</td>
				</tr>
			</table>
		</div>
		
		
		<div class="footer">
			<div class="footer_left">
				&copy; 2010 <a href="#">The Nubio Team</a><br />
				
				<?php echo link_to( 'View Source', 'http://code.google.com/p/nubio/source/browse/trunk' ); ?><br />
				
				<a href="http://validator.w3.org/check?uri=referer"><img src="<?php echo image_path( 'xhtml.png' ) ?>" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
				<a href="http://anybrowser.org/campaign"><img src="<?php echo image_path( 'anybrowser.png' ) ?>" alt="AnyBrowser compliant" /></a>
				<a href="http://toolserver.org"><img src="<?php echo image_path( 'toolserver.png' ) ?>" alt="Powered by WMF Toolserver" /></a>
				<a href="http://symfony-project.org"><img src="<?php echo image_path( 'symfony.png' ) ?>" alt="Powered by symfony" /></a>
			
			</div>
			
		</div>
	</div>
<script type="text/javascript">if (window.runOnloadHook) runOnloadHook();</script>

</body>

</html>
