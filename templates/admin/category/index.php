<?php

use App\Connection;
use App\Table\CategoryTable;
use App\Auth;

Auth::check();

$router->layout = "admin/layouts/default";
$title = 'Gestion des catégories';
$pdo = Connection::getPDO();
$link = $router->url('admin_categories');
$categories = (new CategoryTable($pdo))->all();

?>

<?php if (isset($_GET['delete'])): ?>
<div class="alert alert-success">
    L'enregistrement a bien été supprimé
</div>
<?php endif ?>

<table class="table">
  <thead>
    <th>#</th>
    <th>Titre</th>
    <th>URL</th>
    <th>
      <a href="<?= $router->url('admin_category_new') ?>" class="btn btn-primary">Nouveau</a>
    </th>
  </thead>
  <tbody>
    <?php foreach($categories as $category): ?>
    <tr>
      <td>#<?= $category->getId() ?></td>
      <td>
        <a href="<?= $router->url('admin_category', ['id' => $category->getId()]) ?>">
        <?= htmlentities($category->getName()) ?>
        </a>
      </td>
      <td>
        <?= $category->getSlug() ?>
      </td>
      <td>
        <a href="<?= $router->url('admin_category', ['id' => $category->getId()]) ?>" class="btn btn-primary">
        Editer
        </a>
        <form action="<?= $router->url('admin_category_delete', ['id' => $category->getId()]) ?>" method="POST" onsubmit="return confirm('Voulez-vous vraiment effectuer cette action ?')" style="display: inline;">
        <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
      </td>
    </tr>
  <?php endforeach ?>
  </tbody>
</table>
