<?php

namespace App\Controllers;

use PDO;
use Exception;
use App\Helpers\SecurityHelper;

class ApiBookController {
    
    // Return list of books as JSON, with optional search functionality
    public static function list() {
        global $db;
        
        try {
            header('Content-Type: application/json');
            
            // Input validation
            $search = SecurityHelper::sanitizeString($_GET['search'] ?? '', 100);
            
            $sql = 'SELECT * FROM books';
            $params = [];
            
            if ($search) {
                $sql .= ' WHERE title LIKE :search OR description LIKE :search';
                $params[':search'] = '%' . $search . '%';
            }
            
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode($books);
            exit;
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
            exit;
        }
    }
} 