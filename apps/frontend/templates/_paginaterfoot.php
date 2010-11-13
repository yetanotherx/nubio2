<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination_foot">
    <a href="?page=1">
      <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/first.png', array('alt' => 'First page', 'title' => 'First page' ) ) ?>
    </a>
 
    <a href="?page=<?php echo $pager->getPreviousPage() ?>">
      <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/previous.png', array('alt' => 'Previous page', 'title' => 'Previous page' ) ) ?>
    </a>
 
    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
 
    <a href="?page=<?php echo $pager->getNextPage() ?>">
      <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/next.png', array('alt' => 'Next page', 'title' => 'Next page' ) ) ?>
    </a>
 
    <a href="?page=<?php echo $pager->getLastPage() ?>">
      <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/last.png', array('alt' => 'Last page', 'title' => 'Last page' ) ) ?>
    </a>
  </div>
<?php endif; ?>
 
<div class="pagination_desc">
  <?php echo sprintf( $text, '<strong>' . count($pager) . '</strong>' ) ?>
  <?php if ($pager->haveToPaginate()): ?>
    - page <strong><?php echo $pager->getPage() ?>/<?php echo $pager->getLastPage() ?></strong>
  <?php endif; ?>
</div>
