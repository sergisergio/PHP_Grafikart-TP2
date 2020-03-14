<?php

use App\Connection;
use App\Table\CategoryTable;
use App\HTML\Form;
use App\Validators\CategoryValidator;
use App\ObjectHelper;
use App\Model\Category;
use App\Auth;

$title = 'ajout';
$errors = [];
$category = new Category();

if (!empty($_POST)) {
  $pdo = Connection::getPDO();
  $categoryTable = new CategoryTable($pdo);
  $v = new CategoryValidator($_POST, $categoryTable, $category->getId());
  //ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);

  // La méthode hydrate ci-dessus ne fonctionne car elle indique un name null donc je passe par les setters ci-dessous
  $category
      ->setName($_POST['name'])
      ->setSlug($_POST['slug']);


  if ($v->validate()) {
    $categoryTable->create([
      'name' => $category->getName(),
      'slug' => $category->getSlug()
    ]);
      header('Location: ' . $router->url('admin_categories', ['id' => $category->getId()]) . '?created=1');
      exit();
  } else {
      $errors = $v->errors();
  }
}
$form = new Form($category, $errors);
?>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
  La catégorie n'a pu être enregistrée
</div>
<?php endif ?>

<h1>Créer une catégorie</h1>

<?php require('_form.php'); ?>
