<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination_foot">
    <a href="?page=1">
      <img src="http://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/Go-first.svg/30px-Go-first.svg.png" alt="First page" title="First page" />
    </a>
 
    <a href="?page=<?php echo $pager->getPreviousPage() ?>">
      <img src="http://upload.wikimedia.org/wikipedia/commons/thumb/1/1f/Go-previous.svg/30px-Go-previous.svg.png" alt="Previous page" title="Previous page" />
    </a>
 
    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
 
    <a href="?page=<?php echo $pager->getNextPage() ?>">
      <img src="http://upload.wikimedia.org/wikipedia/commons/thumb/8/83/Go-next.svg/30px-Go-next.svg.png" alt="Next page" title="Next page" />
    </a>
 
    <a href="?page=<?php echo $pager->getLastPage() ?>">
      <img src="http://upload.wikimedia.org/wikipedia/commons/thumb/e/ed/Go-last.svg/30px-Go-last.svg.png" alt="Last page" title="Last page" />
    </a>
  </div>
<?php endif; ?>
 
<div class="pagination_desc">
  <?php echo sprintf( $text, '<strong>' . count($pager) . '</strong>' ) ?>
  <?php if ($pager->haveToPaginate()): ?>
    - page <strong><?php echo $pager->getPage() ?>/<?php echo $pager->getLastPage() ?></strong>
  <?php endif; ?>
</div>
