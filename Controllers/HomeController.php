<?php

namespace App\Controllers;

use Exception;

class HomeController extends BaseController {

    // Display the main dashboard page with statistics and charts
    public static function index () {
        try {
            $dashboardData = self::getDashboardData();
            self::loadView('home', $dashboardData);
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not load dashboard: ' . $e->getMessage()]);
        }
    }

    // Get all dashboard data including counts and chart information
    private static function getDashboardData() {
        global $db;
        
        try {
            // 1 query for all counts (much more efficient than 3 separate queries)
            $counts = $db->query("
                SELECT 
                    (SELECT COUNT(*) FROM books) as total_books,
                    (SELECT COUNT(*) FROM authors) as total_authors,
                    (SELECT COUNT(*) FROM genres) as total_genres
            ")->fetch(\PDO::FETCH_ASSOC);
            
            // 1 query for all chart data (combines genres and years)
            $chartData = $db->query("
                SELECT 
                    'genre' as type,
                    g.name as label,
                    COUNT(b.id) as value
                FROM genres g
                LEFT JOIN book_genre bg ON g.id = bg.genre_id
                LEFT JOIN books b ON bg.book_id = b.id
                GROUP BY g.id, g.name
                
                UNION ALL
                
                SELECT 
                    'year' as type,
                    published_year as label,
                    COUNT(*) as value
                FROM books
                GROUP BY published_year
                ORDER BY type, label
            ")->fetchAll(\PDO::FETCH_ASSOC);
            
            // File count (can be cached later for better performance)
            $uploadsDir = __DIR__ . '/../public/uploads/';
            $counts['total_uploads'] = is_dir($uploadsDir) ? 
                count(array_diff(scandir($uploadsDir), ['.', '..'])) : 0;
            
            // Split chart data into separate arrays for the view
            $genresData = [];
            $yearsData = [];
            
            foreach ($chartData as $row) {
                if ($row['type'] === 'genre') {
                    $genresData[] = [
                        'name' => $row['label'],
                        'book_count' => $row['value']
                    ];
                } else {
                    $yearsData[] = [
                        'published_year' => $row['label'],
                        'book_count' => $row['value']
                    ];
                }
            }
            
            return [
                'title' => 'Homepage',
                'counts' => $counts,
                'genresData' => $genresData,
                'yearsData' => $yearsData
            ];
        } catch (Exception $e) {
            throw new Exception('Database error: ' . $e->getMessage());
        }
    }
}