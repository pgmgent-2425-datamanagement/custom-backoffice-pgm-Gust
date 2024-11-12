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

        self::loadView('books/form', [
            'genres' => $genres
        ]);
    }

    public static function save() {
        global $db;

        $authorName = $_POST['author'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $publishedYear = $_POST['published_year'];
        $genres = $_POST['genres'];

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

        $success = $book->save();
    
        if ($success) {

            $book_id = $db->lastInsertId();
    
            foreach ($genres as $genre_id) {
                $stmt = $db->prepare("INSERT INTO book_genre (book_id, genre_id) VALUES (:book_id, :genre_id)");
                $stmt->execute([':book_id' => $book_id, ':genre_id' => $genre_id]);
            }

            parent::redirect('/books');
            
        } else {
            parent::redirect('/books');
            
            echo 'Error';
        }
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

        $stmt = $db->prepare("SELECT name FROM authors WHERE id = :author_id");
        $stmt->execute([':author_id' => $book->author_id]);
        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        self::loadView('books/edit', [
            'book' => $book,
            'author' => $author,
            'genres' => $genres,
            'bookGenres' => $bookGenres
        ]);
    }

    public static function update($id) {
        global $db;

        $title = $_POST['title'];
        $description = $_POST['description'];
        $authorName = $_POST['author'];
        $publishedYear = $_POST['published_year'];
        $genres = $_POST['genres'] ?? [];

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

        $stmt = $db->prepare("UPDATE books SET title = :title, description = :description, author_id = :author_id, published_year = :published_year WHERE id = :id");
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':author_id' => $author_id,
            ':published_year' => $publishedYear,
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
