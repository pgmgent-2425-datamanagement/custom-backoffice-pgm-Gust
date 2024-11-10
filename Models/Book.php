<?php
namespace App\Models;

class Book extends BaseModel {

    protected function search($search) {
        $sql = 'SELECT * FROM `' . $this->table . '` 
        WHERE title LIKE :search or description LIKE :search
        ';
        $pdo_statement = $this->db->prepare($sql);
        $pdo_statement->execute([
            ':search' => '%' . $search . '%'
        ]);

        $db_items = $pdo_statement->fetchAll();

        return self::castToModel($db_items);
    }

    public function save() {
        $sql = "INSERT INTO `books` (`title`, `description`, `author_id`, `published_year`) 
        VALUES (:title, :description, :author_id, :published_year)";

        $pdo_statement = $this->db->prepare($sql);
        $pdo_statement->execute([
            ':title' => $this->title,
            ':description' => $this->description,
            ':author_id' => $this->author_id,
            ':published_year' => $this->published_year
        ]);

        $book_id = $this->db->lastInsertId();

        if (!empty($this->genres)) {
            foreach ($this->genres as $genre_id) {
                $sql = "INSERT INTO book_genre (book_id, genre_id) VALUES (:book_id, :genre_id)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':book_id' => $book_id,
                    ':genre_id' => $genre_id
                ]);
            }
        }
    }
}
