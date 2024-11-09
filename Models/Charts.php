<?php
namespace Models;

use PDO;

class Charts {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Voorbeeld: Haal het aantal boeken per jaar op
    public function getBooksPerYear() {
        $sql = "SELECT YEAR(published_date) AS year, COUNT(*) AS count
                FROM books
                GROUP BY YEAR(published_date)
                ORDER BY year DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
