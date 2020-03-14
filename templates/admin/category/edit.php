<?php

use App\Connection;
use App\Table\CategoryTable;
use App\HTML\Form;
use App\Validators\CategoryValidator;
use App\ObjectHelper;
use App\Auth;

$title = 'modification';
$pdo = Connection::getPDO();
$categoryTable = new CategoryTable($pdo);
$category = $categoryTable->find($params['id']);
$success = false;
$errors = [];

if (!empty($_POST)) {
  $v = new CategoryValidator($_POST, $categoryTable, $category->getId());
  //ObjectHelper::hydrate($category, $_POST, ['name', 'slug']);

  $category
      ->setName($_POST['name'])
      ->setSlug($_POST['slug']);

  if ($v->validate()) {
    $categoryTable->update([
      'name' => $category->getName(),
      'slug' => $category->getSlug()
    ], $category->getId());
      $success = true;
  } else {
      $errors = $v->errors();
  }
}
$form = new Form($category, $errors);
?>

<?php if ($success): ?>
<div class="alert alert-success">
  La catégorie a bien été modifiée
</div>
<?php endif ?>

<?php if (isset($_GET['created'])): ?>
<div class="alert alert-success">
  La catégorie a bien été créée
</div>
<?php endif ?>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
  La catégorie n'a pu être modifiée
</div>
<?php endif ?>

<h1>Editer la catégorie <?= htmlentities($category->getName()) ?></h1>

<?php require('_form.php'); ?>
