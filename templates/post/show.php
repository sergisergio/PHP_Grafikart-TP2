<?php

use App\Connection;
use App\Table\PostTable;
use App\Table\CategoryTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();
$post = (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratePosts([$post]);

if($post->getSlug() !== $slug) {
  $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $post->getId()]);
  http_response_code(301);
  header('Location: ' . $url);
  exit();
}

$title = $post->getName();

?>


        <h1 class="card-title"><?= htmlentities($post->getName()) ?></h1>
        <div class="text-muted"><?= $post->getCreatedAt()->format('d F Y') ?></div>
        <?php foreach($post->getCategories() as $k => $category): ?>
            <?php if ($k > 0): ?>,<?php endif ?>
            <a href="<?= $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]); ?>"><?= htmlentities($category->getName()) ?></a>
        <?php endforeach ?>
        <p><?= $post->getFormattedContent() ?></p>
