<form method="post" action="<?php echo url_for('userreg/resetRequest') ?>"
  name="reset_request" id="reset_request">
<p>
Forgot your username or password? No problem! Just enter your username <strong>or</strong>
your email address and click "Reset My Password." You will receive an email message containing both your username and
a link permitting you to change your password if you wish.
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
