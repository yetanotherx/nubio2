<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php 
$vals = $form->getOption('currentVals'); 
?>

<?php echo form_tag_for($form, '@topic') ?>
  <table class="prettytable topic_form">
    <tfoot>
      <tr>
        <td colspan="2">
          &nbsp;<?php echo link_to('Back to topic', 'topic/show?id=' . $vals['id']) ?>
          <?php if( !$form->getOption('disabled') ) { ?><input type="submit" value="Save" /><?php } ?>        
		</td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
</form>
