<?php

namespace Model;

class Post
{
    private $pdo;
	/* $submitted: Whether or not the form has been submitted */
	private $submitted = false;
    /* sort method */
    private $sort = 'oldest';
    /* search keyword if set */
    private $keyword;
	/* Validation errors of submitted data */
	private $errors = [];
	/* The record being represented. May come from the database or a form submission */
	private $record = [];

	// consturcts single object
	public function __construct(\PDO $pdo, string $sort = 'oldest', string $keyword = '', bool $submitted = false, array $record = [], array $errors = []) {
		$this->pdo = $pdo;
        $this->sort = $sort;
        $this->keyword = $keyword;
		$this->record = $record;
		$this->submitted = $submitted;
		$this->errors = $errors;
	}

	/*
	* @description load a record from the database
	* @param $id - ID of the record to load from the database
	*/
	public function load(int $id): Post {
		$stmt = $this->pdo->prepare('SELECT p.id, p.subject, p.content, u.first_name, u.last_name FROM post p JOIN user u ON p.user_id = u.id WHERE p.id = :id');
		$stmt->execute(['id' => $id]);
		$record = $stmt->fetch();
		return new Post($this->pdo, $sort = 'oldest', $keyword = '', $this->submitted, $record);
	}
	/*
	* @description return the record currently being represented
	*              this may have come from the DB or $_POST
	*/
	public function getPost(): array {
		return $this->record;
	}
	/*
	* @description has the form been submitted or not?
	*/
	public function isSubmitted(): bool {
		return $this->submitted;
	}
	/*
	* @description return a list of validation errors in the current $record
	*/
	public function getErrors(): array {
		return $this->errors;
	}
	/*
	* @description attempt to save $record to the database, insert or update
    *			   depending on whether $record['id'] is set
	*/
	public function save(array $record): Post {
		$errors = $this->validate($record);
		if (!empty($errors)) {
			// Return a new instance with $record set to the form submission
			// When the view displays the joke, it will display the invalid
			// form submission back in the box
			return new Post($this->pdo, true, $record, $errors);
		}
		if (!empty($record['id'])) {
			return $this->update($record);
		}
		else {
			return $this->insert($record);
		}
	}
	/*
	* @description validates $record
	*/
	private function validate(array $record): array {
		$errors = [];
		if (empty($record['subject'])) {
			$errors[] = 'Subject cannot be blank';
		}
        if (empty($record['content'])) {
            $errors[] = 'Content cannot be blank';
        }
		return $errors;
	}
	/*
	* @description save the record using an UPDATE query
	*/
	private function update(array $record): Post {
		$stmt = $this->pdo->prepare('UPDATE post SET subject = :subject, content = :content WHERE id = :id');
		$stmt->execute([
                        'subject' => $record['subject'],
                        'content' => $record['content'],
                        'id'      => $record['id']
        ]);
		return new Post($this->pdo, $sort = 'oldest', $keyword = '', true, $record);
	}
	/*
	* @description save the record using an INSERT query
	*/
	private function insert(array $record): Post {
		$stmt = $this->pdo->prepare('INSERT INTO post (subject, content, user_id) VALUES(:subject, :content, :user_id)');
		$stmt->execute([
		                'subject' => $record['subject'],
		                'content' => $record['content'],
		                'user_id' => $record['user_id']
		]);
		$record['id'] = $this->pdo->lastInsertId();
		return new Post($this->pdo, $sort = 'oldest', $keyword = '', true, $record);
	}

// list methods

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