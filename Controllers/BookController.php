<?php
namespace App\Controllers;

use App\Models\Book;
use PDO;

class BookController extends BaseController {

    public static function list () {
        $search = $_GET['search'] ?? '';
        $list = Book::search($search);

        self::loadView('books/list', [
            'list' => $list,
            'search' => $search
        ]);
    }

    public static function detail($id) {
        $book = Book::find($id);

        global $db;
        $stmt = $db->prepare("SELECT * FROM authors WHERE id = :author_id");
        $stmt->execute([':author_id' => $book->author_id]);
        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        self::loadView('books/detail', [
            'book' => $book,
            'author' => $author
        ]);
    }

    public static function add () {
        self::loadView('books/form');
    }

    public static function save() {
        global $db;

        $authorName = $_POST['author'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $publishedYear = $_POST['published_year'];

        $stmt = $db->prepare("SELECT id FROM authors WHERE name = :name");
        $stmt->execute([':name' => $authorName]);
        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($author) {
            $author_id = $author['id'];
        } else {
            $stmt = $db->prepare("INSERT INTO authors (name) VALUES (:name)");
            $stmt->execute([':name' => $authorName]);
            $author_id = $db->lastInsertId();
        }

        $book = new Book();
        $book->title = $title;
        $book->description = $description;
        $book->author_id = $author_id;
        $book->published_year = $publishedYear;

        $succes = $book->save();

        if ($succes) {
            header('Location: /books');
            parent::redirect('/books');
        } else {
            echo 'Error';
        }
    }
}
