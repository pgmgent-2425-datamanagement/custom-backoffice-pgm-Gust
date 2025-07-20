<?php

namespace App\Controllers;

use PDO;

class ApiBookController {
    public static function list() {
        global $db;
        header('Content-Type: application/json');
        $search = $_GET['search'] ?? '';
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
    }

    public static function addComment() {
        global $db;
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['book_id'], $input['author'], $input['content'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }
        $stmt = $db->prepare('INSERT INTO reviews (book_id, author, content, created_at) VALUES (:book_id, :author, :content, NOW())');
        $stmt->execute([
            ':book_id' => $input['book_id'],
            ':author' => $input['author'],
            ':content' => $input['content']
        ]);
        echo json_encode(['success' => true, 'id' => $db->lastInsertId()]);
        exit;
    }
} 