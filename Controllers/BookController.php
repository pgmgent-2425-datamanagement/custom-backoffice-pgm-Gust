<?php

namespace App\Controllers;

use App\Models\Book;
use PDO;

class BookController extends BaseController {

    public static function list() {
        $search = $_GET['search'] ?? '';

        $list = Book::search($search);

        self::loadView('books/list', [
            'list' => $list,
            'search' => $search
        ]);
    }

    public static function detail($id) {
        global $db;

        $book = Book::find($id);
        if (!$book) {
            echo "Book not found.";
            exit;
        }

        $stmt = $db->prepare("SELECT * FROM genres INNER JOIN book_genre ON genres.id = book_genre.genre_id WHERE book_genre.book_id = :id");
        $stmt->execute([':id' => $id]);
        $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $db->prepare("SELECT name FROM authors WHERE id = :author_id");
        $stmt->execute([':author_id' => $book->author_id]);
        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        self::loadView('books/detail', [
            'book' => $book,
            'author' => $author,
            'genres' => $genres
        ]);
    }

    public static function add() {
        global $db;

        $stmt = $db->query("SELECT * FROM genres");
        $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $db->query("SELECT * FROM authors ORDER BY name");
        $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        self::loadView('books/form', [
            'genres' => $genres,
            'authors' => $authors
        ]);
    }

    public static function save() {
        global $db;

        $author_id = $_POST['author_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $publishedYear = $_POST['published_year'];
        $genres = $_POST['genres'];

        // Afbeelding uploaden
        $imageName = null;
        $uploadError = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('book_', true) . '.' . $ext;
                $uploadPath = __DIR__ . '/../public/uploads/' . $imageName;
                if (!is_dir(__DIR__ . '/../public/uploads/')) {
                    mkdir(__DIR__ . '/../public/uploads/', 0777, true);
                }
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $uploadError = 'Fout bij het opslaan van het bestand.';
                }
            } else {
                $uploadError = 'Uploadfout: ' . $_FILES['image']['error'];
            }
        }
        if ($uploadError) {
            die('Upload error: ' . $uploadError);
        }

        $sql = "INSERT INTO books (title, description, author_id, published_year, image) VALUES (:title, :description, :author_id, :published_year, :image)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':author_id' => $author_id,
            ':published_year' => $publishedYear,
            ':image' => $imageName
        ]);
        $book_id = $db->lastInsertId();

        foreach ($genres as $genre_id) {
            $stmt = $db->prepare("INSERT INTO book_genre (book_id, genre_id) VALUES (:book_id, :genre_id)");
            $stmt->execute([':book_id' => $book_id, ':genre_id' => $genre_id]);
        }

        parent::redirect('/books');
    }
    
    
    public static function delete($id) {
        global $db;

        $stmt = $db->prepare("DELETE FROM book_genre WHERE book_id = :id");
        $stmt->execute([':id' => $id]);
    
        $stmt = $db->prepare("DELETE FROM books WHERE id = :id");
        $stmt->execute([':id' => $id]);
    
        header('Location: /books');
        exit;
    }
    

    public static function edit($id) {
        global $db;

        $book = Book::find($id);
        if (!$book) {
            echo "Book not found.";
            exit;
        }

        $stmt = $db->query("SELECT * FROM genres");
        $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $db->prepare("SELECT genre_id FROM book_genre WHERE book_id = :id");
        $stmt->execute([':id' => $id]);
        $bookGenres = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'genre_id');

        $stmt = $db->query("SELECT * FROM authors ORDER BY name");
        $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $db->prepare("SELECT name FROM authors WHERE id = :author_id");
        $stmt->execute([':author_id' => $book->author_id]);
        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        self::loadView('books/edit', [
            'book' => $book,
            'author' => $author,
            'genres' => $genres,
            'bookGenres' => $bookGenres,
            'authors' => $authors
        ]);
    }

    public static function update($id) {
        global $db;

        $title = $_POST['title'];
        $description = $_POST['description'];
        $author_id = $_POST['author_id'];
        $publishedYear = $_POST['published_year'];
        $genres = $_POST['genres'] ?? [];

        // Afbeelding uploaden (optioneel)
        $imageName = null;
        $uploadError = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('book_', true) . '.' . $ext;
                $uploadPath = __DIR__ . '/../public/uploads/' . $imageName;
                if (!is_dir(__DIR__ . '/../public/uploads/')) {
                    mkdir(__DIR__ . '/../public/uploads/', 0777, true);
                }
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $uploadError = 'Fout bij het opslaan van het bestand.';
                }
            } else {
                $uploadError = 'Uploadfout: ' . $_FILES['image']['error'];
            }
        }
        if ($uploadError) {
            die('Upload error: ' . $uploadError);
        }

        // Haal huidige afbeelding op
        $stmt = $db->prepare("SELECT image FROM books WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $current = $stmt->fetch(PDO::FETCH_ASSOC);
        $finalImage = $imageName ?: $current['image'];

        $stmt = $db->prepare("UPDATE books SET title = :title, description = :description, author_id = :author_id, published_year = :published_year, image = :image WHERE id = :id");
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':author_id' => $author_id,
            ':published_year' => $publishedYear,
            ':image' => $finalImage,
            ':id' => $id
        ]);

        $stmt = $db->prepare("DELETE FROM book_genre WHERE book_id = :id");
        $stmt->execute([':id' => $id]);

        foreach ($genres as $genre_id) {
            $stmt = $db->prepare("INSERT INTO book_genre (book_id, genre_id) VALUES (:book_id, :genre_id)");
            $stmt->execute([':book_id' => $id, ':genre_id' => $genre_id]);
        }

        header('Location: /book/' . $id);
        exit;
    }
}
