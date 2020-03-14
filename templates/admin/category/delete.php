<?php

use App\Connection;
use App\Table\categoryTable;
use App\Auth;

Auth::check();

$title = 'suppression';
$pdo = Connection::getPDO();
$table = new CategoryTable($pdo);
$table->delete($params['id']);
header('Location: ' . $router->url('admin_categories') . '?delete=1');
