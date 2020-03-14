<?php

use App\Connection;
use App\Table\PostTable;
use App\Table\CategoryTable;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\ObjectHelper;
use App\Auth;

$title = 'modification';
$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
$post = $postTable->find($params['id']);
$categoryTable->hydratePosts([$post]);
$success = false;
$errors = [];

if (!empty($_POST)) {
  $v = new PostValidator($_POST, $postTable, $post->getId(), $categories);
  //ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);

  $post
      ->setName($_POST['name'])
      ->setContent($_POST['content'])
      ->setSlug($_POST['slug'])
      ->setCreatedAt(date('Y-m-d H:i:s'));

  if ($v->validate()) {
    $pdo->beginTransaction();
    $postTable->updatePost($post);
    $postTable->attachCategories($post->getId(), $_POST['categories_ids']);
    $pdo->commit();
    $categoryTable->hydratePosts([$post]);
      $success = true;
  } else {
      $errors = $v->errors();
  }
}
$form = new Form($post, $errors);
?>

<?php if ($success): ?>
<div class="alert alert-success">
  L'article a bien été modifié
</div>
<?php endif ?>

<?php if (isset($_GET['created'])): ?>
<div class="alert alert-success">
  L'article a bien été créé
</div>
<?php endif ?>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
  L'article n'a pu être modifié
</div>
<?php endif ?>

<h1>Editer l'article <?= htmlentities($post->getName()) ?></h1>

<?php require('_form.php'); ?>
