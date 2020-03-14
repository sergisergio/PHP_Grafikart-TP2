<?php

namespace App\Table;

use App\Model\Category;
use \PDO;

final class CategoryTable extends Table
{
  protected $table = "category";
  protected $class = Category::class;
  /**
   * @param App\Model\Post[] $posts
   */
  public function hydratePosts(array $posts): void
  {
      $postsById = [];
      foreach($posts as $post) {
        $post->setCategories([]);
        $postsById[$post->getId()] = $post;
      }
      $categories = $this->pdo
          ->query('SELECT c.*, pc.post_id
              FROM post_category pc
              JOIN category c ON c.id = pc.category_id
              WHERE pc.post_id IN (' . implode(',', array_keys($postsById)) . ')')
          ->fetchAll(PDO::FETCH_CLASS, $this->class);

      // On parcourt les catégories
      foreach($categories as $category) {
          $postsById[$category->getPostId()]->addCategory($category);
      }
  }

  public function all(): array
  {
    $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
    return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
  }

  public function list(): array
  {
    $categories = $this->all();
    $results = [];
    foreach($categories as $category) {
      $results[$category->getId()] = $category->getName();
    }
    return $results;
  }
}
