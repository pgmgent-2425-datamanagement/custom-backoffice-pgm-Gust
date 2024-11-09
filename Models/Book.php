<?php

namespace App\Models;

class Book extends BaseModel {
    protected function search ($search) {
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
    public function save () {
        // print_r("doe de save van een boek");
        $sql = "INSERT INTO `books` (`title`, `description`) VALUES (:name, :description)";

        $pdo_statement = $this->db->prepare($sql);
        $pdo_statement->execute([
            ':name' => $this->title,
            ':description' => $this->description
        ]);


    }
}