<?php

namespace App\Table;

use App\PaginatedQuery;
use App\Model\Post;

final class PostTable extends Table
{
  protected $table = "post";
  protected $class = Post::class;

  public function updatePost(Post $post): void
  {
    //$query = $this->pdo->prepare("UPDATE {$this->table} SET name = :name, slug = :slug, created_at = :created, content = :content WHERE id = :id");
    $this->update([
        'name' => $post->getName(),
        'slug' => $post->getSlug(),
        'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
        'content' => $post->getContent()
    ], $post->getId());

  }

  public function createPost(Post $post): void
  {
    $id = $this->create([
        'name' => $post->getName(),
        'slug' => $post->getSlug(),
        'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
        'content' => $post->getContent()
    ]);
    $post->setId($id);
  }

  public function attachCategories(int $id, array $categories)
  {
    $this->pdo->exec('DELETE FROM post_category WHERE post_id = ' . $id);
    $query = $this->pdo->prepare('INSERT INTO post_category SET post_id = ?, category_id = ?');
    foreach($categories as $category) {
      $query->execute([$id, $category]);
    }
  }

  public function deletePost(int $id): void
  {
    $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
    $ok = $query->execute([$id]);
    if ($ok === false) {
      throw new \Exception("Impossible de supprimer l'enregistrement $id dans la table ($this->table)");
    }
  }

  public function findPaginated()
  {
    $paginatedQuery = new PaginatedQuery(
        "SELECT * FROM {$this->table} ORDER BY created_at DESC",
        "SELECT COUNT(id) FROM {$this->table}",
        $this->pdo
    );
    $posts = $paginatedQuery->getItems(Post::class);
    (new CategoryTable($this->pdo))->hydratePosts($posts);
    return [$posts, $paginatedQuery];
  }

  public function findPaginatedForCategory(int $categoryID)
  {

      $paginatedQuery = new paginatedQuery(
        "SELECT p.*
          FROM {$this->table} p
          JOIN post_category pc ON pc.post_id = p.id
          WHERE pc.category_id = {$categoryID}
          ORDER BY created_at DESC",
        "SELECT COUNT(category_id)
          FROM post_category
          WHERE category_id = {$categoryID}"

      );
      $posts = $paginatedQuery->getItems(Post::class);
      (new CategoryTable($this->pdo))->hydratePosts($posts);
      return [$posts, $paginatedQuery];
  }
}
