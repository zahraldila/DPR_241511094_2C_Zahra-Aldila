<?php
// Bootstrap 5 pagination template untuk CI4
$pager->setSurroundCount(2);
?>
<nav aria-label="Page navigation">
  <ul class="pagination justify-content-end mb-0">
    <?php if ($pager->hasPrevious()) : ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="First">
          <span aria-hidden="true">«</span>
        </a>
      </li>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getPreviousPage() ?>" aria-label="Previous">
          <span aria-hidden="true">‹</span>
        </a>
      </li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link): ?>
      <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
        <a class="page-link" href="<?= $link['uri'] ?>">
          <?= $link['title'] ?>
        </a>
      </li>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getNextPage() ?>" aria-label="Next">
          <span aria-hidden="true">›</span>
        </a>
      </li>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getLast() ?>" aria-label="Last">
          <span aria-hidden="true">»</span>
        </a>
      </li>
    <?php endif ?>
  </ul>
</nav>
