<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('userreg/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
	<table class="prettytable topic_form">
		<tfoot>
			<tr>
				<th colspan="2">Password - <?php echo link_to( 'Change password', '@userreg_resetrequest' ) ?></th>
			</tr>
			<tr>
				<td colspan="2">
					&nbsp;<?php if( !is_null( $sf_user->getGuardUser() ) ) echo link_to( 'Back to profile', 'user/show?id=' . $sf_user->getGuardUser()->getId() ) ?>
					<input type="submit" value="Save" />
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php echo $form ?>
		</tbody>
	</table>
</form>
