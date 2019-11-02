<?php

namespace Model;

class Posts
{
  /* database connection */
  private $pdo;
  /* sort method */
  private $sort = 'oldest';
  /* search keyword if set */
  private $keyword;
  public function __construct(\PDO $pdo, string $sort = 'oldest', string $keyword = '')
  {
    $this->pdo = $pdo;
    $this->sort = $sort;
    $this->keyword = $keyword;
  }
  public function sort($dir): self
  {
    return new self($this->pdo, $dir, $this->keyword);
  }
  public function search($keyword): self
  {
    return new self($this->pdo, $this->sort, $keyword);
  }
  public function getKeyword(): string
  {
    return $this->keyword;
  }
  public function getSort(): string
  {
    return $this->sort;
  }
  public function delete($id): self
  {
    $stmt = $this->pdo->prepare('DELETE FROM post WHERE id = :id');
    $stmt->execute(['id' => $id]);
    return $this;
  }
  public function getPosts(): array
  {
    $parameters = [];
    if ($this->sort == 'newest') {
      $order = ' ORDER BY p.id DESC';
    } else if ($this->sort == 'oldest') {
      $order = ' ORDER BY p.id ASC';
    } else {
      $order = '';
    }
    if ($this->keyword) {
      $where = ' WHERE content LIKE :text';
      $parameters['text'] = '%' . $this->keyword . '%';
    } else {
      $where = '';
    }
    $stmt = $this->pdo->prepare('SELECT p.id, p.subject, p.content, u.first_name, u.last_name FROM post p JOIN user u ON p.user_id = u.id' . $where . $order);
    $stmt->execute($parameters);
    return $stmt->fetchAll();
  }
}
