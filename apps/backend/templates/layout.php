<?php

use_helper( 'Number' );
use_helper( 'Text' );
use_helper( 'crossAppLink' );

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<?php include_http_metas() ?>
    <?php include_metas() ?>
	<link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
	<title>Nubio Admin Panel</title>
</head>

<body>
	<div class="wrapper" style="width: 90%;">
		<div class="header_bar">
			<span style="font-size:125%;"><a href="<?php echo url_for('homepage') ?>" style="text-decoration:none;"><span style="color:#fff;">Nubio</span></a></span>
		</div>
		<div class="main_content">

			<table class="content_table" style="width:100%;">
				<tr>
					<td class="content_box main_box">
						<h2 class="green head">Admin panel</h2>
											
						<div id="sf_content"><?php echo $sf_content ?></div>
						
					</td>
					<td class="content_box nav_box">
						<h2 class="green head">Navigation</h2>
						<ul>
							<li><?php echo link_to( 'Admin home', '@homepage' ) ?></li>							
							<li><?php echo link_to( 'Topics', 'nubio_topic' ) ?></li>
							<li><?php echo link_to( 'Revisions', 'nubio_revision' ) ?></li>
							<li><?php echo link_to( 'Categories', 'nubio_category' ) ?></li>
							<li><?php echo link_to( 'Helpers', 'nubio_helper' ) ?></li>
							<li><?php echo link_to( 'Back to main site', cross_app_url_for( 'frontend', '@homepage' ) ) ?></li>
						</ul>
	

					</td>
				</tr>
			</table>
		</div>
		
		
		<div class="footer">
			<div class="footer_left">
				<a href="http://validator.w3.org/check?uri=referer"><img src="/~soxred93/images/xhtml.png" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
				<a href="http://anybrowser.org/campaign"><img src="/~soxred93/images/anybrowser.png" alt="AnyBrowser compliant" /></a>
				<a href="http://toolserver.org"><img src="/~soxred93/images/toolserver.png" alt="Powered by WMF Toolserver" /></a>
				<a href="http://symfony-project.org"><img src="/~soxred93/images/symfony.png" alt="Powered by symfony" /></a>
			
			</div>
			
		</div>
	</div>
<script type="text/javascript">if (window.runOnloadHook) runOnloadHook();</script>

</body>

</html>
