<?php

$categories = [];
foreach($post->getCategories() as $category) {
  $url = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
  $categories[] = <<<HTML
    <a href="{$url}">{$category->getName()}</a>
HTML;
}
?>
<div class=" mb-3">
      <div class="card-body">
        <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
        <div class="text-muted">
          <?= $post->getCreatedAt()->format('d F Y') ?>
          <?php if (!empty($post->getCategories())): ?>
          ::
          <?= implode(', ', $categories) ?>
        <?php endif ?>
          </div>
        <p><?= $post->getExcerpt() ?></p>
        <p>
          <a href="<?= $router->url('post', ['id' => $post->getId(), 'slug' => $post->getSlug()]); ?>" class="btn btn-primary">Voir plus</a>
        </p>
      </div>
    </div>
