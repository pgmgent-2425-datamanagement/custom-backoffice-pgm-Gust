<?php

namespace App\Controllers;

use PDO;
use Exception;
use App\Helpers\SecurityHelper;

class AuthorController extends BaseController {
    
    // Display list of all authors
    public static function list() {
        global $db;
        
        try {
            $stmt = $db->query("SELECT * FROM authors ORDER BY name");
            $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $csrfToken = SecurityHelper::generateCSRFToken();
            self::loadView('authors/list', ['authors' => $authors, 'csrf_token' => $csrfToken]);
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not load authors: ' . $e->getMessage()]);
        }
    }

    // Display form to add a new author
    public static function add() {
        $csrfToken = SecurityHelper::generateCSRFToken();
        self::loadView('authors/form', ['author' => null, 'csrf_token' => $csrfToken]);
    }

    // Save a new author to the database
    public static function save() {
        global $db;
        
        // CSRF protection
        if (!SecurityHelper::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            self::loadView('error', ['message' => 'Invalid CSRF token']);
            return;
        }
        
        try {
            // Input validation and sanitization
            $name = SecurityHelper::sanitizeString($_POST['name'] ?? '', 100);
            $birth_date = SecurityHelper::sanitizeDate($_POST['birth_date'] ?? '');
            
            if (empty($name)) {
                self::loadView('error', ['message' => 'Name is required and must be less than 100 characters']);
                return;
            }
            
            // Insert author
            $stmt = $db->prepare("INSERT INTO authors (name, birth_date) VALUES (:name, :birth_date)");
            $stmt->execute([':name' => $name, ':birth_date' => $birth_date]);
            
            parent::redirect('/authors');
            
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not save author: ' . $e->getMessage()]);
        }
    }

    // Display form to edit an existing author
    public static function edit($id) {
        global $db;
        
        try {
            // Validate ID
            $id = SecurityHelper::sanitizeInt($id, 1);
            if (!$id) {
                self::loadView('error', ['message' => 'Invalid author ID']);
                return;
            }
            
            $stmt = $db->prepare("SELECT * FROM authors WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $author = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$author) {
                self::loadView('error', ['message' => 'Author not found']);
                return;
            }
            
            $csrfToken = SecurityHelper::generateCSRFToken();
            self::loadView('authors/form', ['author' => $author, 'csrf_token' => $csrfToken]);
            
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not load author: ' . $e->getMessage()]);
        }
    }

    // Update an existing author in the database
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
                self::loadView('error', ['message' => 'Invalid author ID']);
                return;
            }
            
            // Input validation and sanitization
            $name = SecurityHelper::sanitizeString($_POST['name'] ?? '', 100);
            $birth_date = SecurityHelper::sanitizeDate($_POST['birth_date'] ?? '');
            
            if (empty($name)) {
                self::loadView('error', ['message' => 'Name is required and must be less than 100 characters']);
                return;
            }
            
            // Update author
            $stmt = $db->prepare("UPDATE authors SET name = :name, birth_date = :birth_date WHERE id = :id");
            $stmt->execute([':name' => $name, ':birth_date' => $birth_date, ':id' => $id]);
            
            parent::redirect('/authors');
            
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not update author: ' . $e->getMessage()]);
        }
    }

    // Delete an author from the database
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
                self::loadView('error', ['message' => 'Invalid author ID']);
                return;
            }
            
            // Check if author has books
            $stmt = $db->prepare("SELECT COUNT(*) FROM books WHERE author_id = :id");
            $stmt->execute([':id' => $id]);
            $bookCount = $stmt->fetchColumn();
            
            if ($bookCount > 0) {
                self::loadView('error', ['message' => 'Cannot delete author with existing books. Please delete or reassign books first.']);
                return;
            }
            
            // Delete author
            $stmt = $db->prepare("DELETE FROM authors WHERE id = :id");
            $stmt->execute([':id' => $id]);
            
            parent::redirect('/authors');
            
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not delete author: ' . $e->getMessage()]);
        }
    }
} 