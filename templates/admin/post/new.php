<?php

use App\Connection;
use App\Table\PostTable;
use App\Table\CategoryTable;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\ObjectHelper;
use App\Model\Post;
use App\Auth;

$title = 'ajout';
$errors = [];
$post = new Post();
$pdo = Connection::getPDO();
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();

if (!empty($_POST)) {
  $postTable = new PostTable($pdo);
  $v = new PostValidator($_POST, $postTable, $post->getId(), $categories);
  //ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);

  // La méthode hydrate ci-dessus ne fonctionne car elle indique un name null donc je passe par les setters ci-dessous
  $post
      ->setName($_POST['name'])
      ->setContent($_POST['content'])
      ->setSlug($_POST['slug'])
      ->setCreatedAt(date('Y-m-d H:i:s'));


  if ($v->validate()) {
    $pdo->beginTransaction();
    $postTable->createPost($post);
    $postTable->attachCategories($post->getId(), $_POST['categories_ids']);
    $pdo->commit();
      header('Location: ' . $router->url('admin_post', ['id' => $post->getId()]) . '?created=1');
      exit();
  } else {
      $errors = $v->errors();
  }
}
$form = new Form($post, $errors);
?>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
  L'article n'a pu être enregistré
</div>
<?php endif ?>

<h1>Créer un article</h1>

<?php require('_form.php'); ?>
