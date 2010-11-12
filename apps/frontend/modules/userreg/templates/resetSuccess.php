<form method="post" action="<?php echo url_for('userreg/reset') ?>"
  name="reset_request" id="reset_request">
<p>
Thanks for confirming your email address. You may now change your
password using the form below.
</p>
<ul>
<?php echo $form ?>
<li>
<input type="submit" value="Reset My Password"> 
or
<?php echo link_to('Cancel', '@homepage') ?>
</li>
</ul>
</form>
