<?php

namespace App\Controllers;

use App\Models\Book;
use PDO;
use Exception;
use App\Helpers\SecurityHelper;

class BookController extends BaseController {

    // Display list of all books with search functionality
    public static function list() {
        $search = SecurityHelper::sanitizeString($_GET['search'] ?? '', 100);

        try {
            $list = Book::search($search);
            $csrfToken = SecurityHelper::generateCSRFToken();
            self::loadView('books/list', [
                'list' => $list,
                'search' => $search,
                'csrf_token' => $csrfToken
            ]);
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not load books: ' . $e->getMessage()]);
        }
    }

    // Display detailed information about a specific book
    public static function detail($id) {
        global $db;

        try {
            // Validate ID
            $id = SecurityHelper::sanitizeInt($id, 1);
            if (!$id) {
                self::loadView('error', ['message' => 'Invalid book ID']);
                return;
            }

            $book = Book::find($id);
            if (!$book) {
                self::loadView('error', ['message' => 'Book not found']);
                return;
            }

            // Get genres for this book
            $stmt = $db->prepare("SELECT * FROM genres INNER JOIN book_genre ON genres.id = book_genre.genre_id WHERE book_genre.book_id = :book_id");
            $stmt->execute([':book_id' => $id]);
            $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Get author for this book
            $stmt = $db->prepare("SELECT * FROM authors WHERE id = :author_id");
            $stmt->execute([':author_id' => $book->author_id]);
            $author = $stmt->fetch(PDO::FETCH_ASSOC);

            $csrfToken = SecurityHelper::generateCSRFToken();
            self::loadView('books/detail', [
                'book' => $book,
                'genres' => $genres,
                'author' => $author,
                'csrf_token' => $csrfToken
            ]);
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not load book details: ' . $e->getMessage()]);
        }
    }

    // Display form to add a new book
    public static function add() {
        global $db;

        try {
            // Get all genres
            $stmt = $db->query("SELECT * FROM genres");
            $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Get all authors
            $stmt = $db->query("SELECT * FROM authors ORDER BY name");
            $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $csrfToken = SecurityHelper::generateCSRFToken();
            self::loadView('books/form', [
                'genres' => $genres,
                'authors' => $authors,
                'csrf_token' => $csrfToken
            ]);
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not load form: ' . $e->getMessage()]);
        }
    }

    // Save a new book to the database
    public static function save() {
        global $db;

        // CSRF protection
        if (!SecurityHelper::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            self::loadView('error', ['message' => 'Invalid CSRF token']);
            return;
        }

        try {
            // Input validation and sanitization
            $author_id = SecurityHelper::sanitizeInt($_POST['author_id'] ?? '', 1);
            $title = SecurityHelper::sanitizeString($_POST['title'] ?? '', 255);
            $description = SecurityHelper::sanitizeString($_POST['description'] ?? '', 1000);
            $publishedYear = SecurityHelper::sanitizeInt($_POST['published_year'] ?? '', 1900, date('Y'));
            $genres = $_POST['genres'] ?? [];

            // Validate required fields
            if (empty($title) || empty($description) || !$author_id || !$publishedYear) {
                self::loadView('error', ['message' => 'All required fields must be filled']);
                return;
            }

            // Validate genres array
            if (!is_array($genres)) {
                $genres = [];
            }

            // Handle image upload with security validation
            $imageName = null;
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxSize = 5 * 1024 * 1024; // 5MB

            $uploadResult = SecurityHelper::validateFileUpload($_FILES['image'] ?? null, $allowedTypes, $maxSize);
            
            if (!$uploadResult['valid']) {
                self::loadView('error', ['message' => $uploadResult['error']]);
                return;
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $imageName = SecurityHelper::generateSafeFilename($_FILES['image']['name'], 'book_');
                $uploadPath = __DIR__ . '/../public/uploads/' . $imageName;
                
                if (!is_dir(__DIR__ . '/../public/uploads/')) {
                    mkdir(__DIR__ . '/../public/uploads/', 0755, true);
                }
                
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    self::loadView('error', ['message' => 'Error saving uploaded file']);
                    return;
                }
            }

            // Insert book into database
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

            // Insert genre relationships
            foreach ($genres as $genre_id) {
                $genre_id = SecurityHelper::sanitizeInt($genre_id, 1);
                if ($genre_id) {
                    $stmt = $db->prepare("INSERT INTO book_genre (book_id, genre_id) VALUES (:book_id, :genre_id)");
                    $stmt->execute([':book_id' => $book_id, ':genre_id' => $genre_id]);
                }
            }

            parent::redirect('/books');
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not save book: ' . $e->getMessage()]);
        }
    }

    // Delete a book and its genre relationships
    public static function delete($id) {
        global $db;

        // CSRF protection
        if (!SecurityHelper::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            self::loadView('error', ['message' => 'Invalid CSRF token']);
            return;
        }

        try {
            // Validate ID
            $id = SecurityHelper::sanitizeInt($id, 1);
            if (!$id) {
                self::loadView('error', ['message' => 'Invalid book ID']);
                return;
            }

            // Delete genre relationships first
            $stmt = $db->prepare("DELETE FROM book_genre WHERE book_id = :id");
            $stmt->execute([':id' => $id]);

            // Delete the book
            $stmt = $db->prepare("DELETE FROM books WHERE id = :id");
            $stmt->execute([':id' => $id]);

            parent::redirect('/books');
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not delete book: ' . $e->getMessage()]);
        }
    }

    // Display form to edit an existing book
    public static function edit($id) {
        global $db;

        try {
            // Validate ID
            $id = SecurityHelper::sanitizeInt($id, 1);
            if (!$id) {
                self::loadView('error', ['message' => 'Invalid book ID']);
                return;
            }

            $book = Book::find($id);
            if (!$book) {
                self::loadView('error', ['message' => 'Book not found']);
                return;
            }

            // Get all genres
            $stmt = $db->query("SELECT * FROM genres");
            $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Get current genres for this book
            $stmt = $db->prepare("SELECT genre_id FROM book_genre WHERE book_id = :id");
            $stmt->execute([':id' => $id]);
            $bookGenres = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'genre_id');

            // Get all authors
            $stmt = $db->query("SELECT * FROM authors ORDER BY name");
            $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $csrfToken = SecurityHelper::generateCSRFToken();
            self::loadView('books/form', [
                'book' => $book,
                'genres' => $genres,
                'bookGenres' => $bookGenres,
                'authors' => $authors,
                'csrf_token' => $csrfToken
            ]);
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not load edit form: ' . $e->getMessage()]);
        }
    }

    // Update an existing book in the database
    public static function update($id) {
        global $db;

        // CSRF protection
        if (!SecurityHelper::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            self::loadView('error', ['message' => 'Invalid CSRF token']);
            return;
        }

        try {
            // Validate ID
            $id = SecurityHelper::sanitizeInt($id, 1);
            if (!$id) {
                self::loadView('error', ['message' => 'Invalid book ID']);
                return;
            }

            // Input validation and sanitization
            $author_id = SecurityHelper::sanitizeInt($_POST['author_id'] ?? '', 1);
            $title = SecurityHelper::sanitizeString($_POST['title'] ?? '', 255);
            $description = SecurityHelper::sanitizeString($_POST['description'] ?? '', 1000);
            $publishedYear = SecurityHelper::sanitizeInt($_POST['published_year'] ?? '', 1900, date('Y'));
            $genres = $_POST['genres'] ?? [];

            // Validate required fields
            if (empty($title) || empty($description) || !$author_id || !$publishedYear) {
                self::loadView('error', ['message' => 'All required fields must be filled']);
                return;
            }

            // Validate genres array
            if (!is_array($genres)) {
                $genres = [];
            }

            // Handle image upload with security validation
            $imageName = null;
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxSize = 5 * 1024 * 1024; // 5MB

            $uploadResult = SecurityHelper::validateFileUpload($_FILES['image'] ?? null, $allowedTypes, $maxSize);
            
            if (!$uploadResult['valid']) {
                self::loadView('error', ['message' => $uploadResult['error']]);
                return;
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $imageName = SecurityHelper::generateSafeFilename($_FILES['image']['name'], 'book_');
                $uploadPath = __DIR__ . '/../public/uploads/' . $imageName;
                
                if (!is_dir(__DIR__ . '/../public/uploads/')) {
                    mkdir(__DIR__ . '/../public/uploads/', 0755, true);
                }
                
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    self::loadView('error', ['message' => 'Error saving uploaded file']);
                    return;
                }
            }

            // Update book in database
            $sql = "UPDATE books SET title = :title, description = :description, author_id = :author_id, published_year = :published_year";
            $params = [
                ':id' => $id,
                ':title' => $title,
                ':description' => $description,
                ':author_id' => $author_id,
                ':published_year' => $publishedYear
            ];

            if ($imageName) {
                $sql .= ", image = :image";
                $params[':image'] = $imageName;
            }

            $sql .= " WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);

            // Update genre relationships
            $stmt = $db->prepare("DELETE FROM book_genre WHERE book_id = :id");
            $stmt->execute([':id' => $id]);

            foreach ($genres as $genre_id) {
                $genre_id = SecurityHelper::sanitizeInt($genre_id, 1);
                if ($genre_id) {
                    $stmt = $db->prepare("INSERT INTO book_genre (book_id, genre_id) VALUES (:book_id, :genre_id)");
                    $stmt->execute([':book_id' => $id, ':genre_id' => $genre_id]);
                }
            }

            parent::redirect('/books');
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not update book: ' . $e->getMessage()]);
        }
    }
}
