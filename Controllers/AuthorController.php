<?php

namespace App\Controllers;

use PDO;

class AuthorController extends BaseController {
    public static function list() {
        global $db;
        $stmt = $db->query("SELECT * FROM authors ORDER BY name");
        $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        self::loadView('authors/list', ['authors' => $authors]);
    }

    public static function add() {
        self::loadView('authors/form', ['author' => null]);
    }

    public static function save() {
        global $db;
        $name = $_POST['name'];
        $birth_date = $_POST['birth_date'] ?: null;
        $stmt = $db->prepare("INSERT INTO authors (name, birth_date) VALUES (:name, :birth_date)");
        $stmt->execute([':name' => $name, ':birth_date' => $birth_date]);
        parent::redirect('/authors');
    }

    public static function edit($id) {
        global $db;
        $stmt = $db->prepare("SELECT * FROM authors WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $author = $stmt->fetch(PDO::FETCH_ASSOC);
        self::loadView('authors/form', ['author' => $author]);
    }

    public static function update($id) {
        global $db;
        $name = $_POST['name'];
        $birth_date = $_POST['birth_date'] ?: null;
        $stmt = $db->prepare("UPDATE authors SET name = :name, birth_date = :birth_date WHERE id = :id");
        $stmt->execute([':name' => $name, ':birth_date' => $birth_date, ':id' => $id]);
        parent::redirect('/authors');
    }

    public static function delete($id) {
        global $db;
        $stmt = $db->prepare("DELETE FROM authors WHERE id = :id");
        $stmt->execute([':id' => $id]);
        parent::redirect('/authors');
    }
} 