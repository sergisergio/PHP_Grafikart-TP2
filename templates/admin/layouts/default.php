<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width-device-width, initial-scale-1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title><?= ($title) ? htmlentities($title) : 'Mon blog' ?></title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body class="d-flex flex-column h-100">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a href="<?= $router->url('home') ?>" class="navbar-brand">Mon site</a>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="<?= $router->url('admin_posts') ?>" class="nav-link">Articles</a>
      </li>
      <li class="nav-item">
        <a href="<?= $router->url('admin_categories') ?>" class="nav-link">Catégories</a>
      </li>
      <li class="nav-item">
        <form action="<?= $router->url('logout') ?>" method="post" style="display:inline">
          <button type="submit" class="nav-link" style="background:transparent;border:none;">Déconnexion</button>
        </form>
      </li>
    </ul>
  </nav>

  <div class="container mt-4">
    <?= $content ?>
  </div>

  <footer class="bg-light py-4 footer mt-auto">
    <div class="container">
      <?php if (defined("DEBUG_TIME")): ?>
      Page générée en  <?= round(1000 * (microtime(true) - DEBUG_TIME)); ?>ms
      <?php endif ?>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
