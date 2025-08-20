<?php

namespace App\Controllers;

use Exception;
use App\Helpers\SecurityHelper;

class FileManagerController extends BaseController {
    
    // Display list of all uploaded files
    public static function index() {
        try {
            $dir = __DIR__ . '/../public/uploads/';
            $files = [];
            if (is_dir($dir)) {
                foreach (scandir($dir) as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $files[] = $file;
                    }
                }
            }
            
            $csrfToken = SecurityHelper::generateCSRFToken();
            self::loadView('filemanager/index', ['files' => $files, 'csrf_token' => $csrfToken]);
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not load files: ' . $e->getMessage()]);
        }
    }

    // Delete a specific file from the uploads directory
    public static function delete($filename) {
        // CSRF protection
        if (!SecurityHelper::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            self::loadView('error', ['message' => 'Invalid CSRF token']);
            return;
        }
        
        try {
            // Security against path traversal
            $file = basename($filename);
            $path = __DIR__ . '/../public/uploads/' . $file;
            
            if (is_file($path)) {
                if (unlink($path)) {
                    parent::redirect('/filemanager');
                } else {
                    self::loadView('error', ['message' => 'Could not delete file']);
                }
            } else {
                self::loadView('error', ['message' => 'File not found']);
            }
        } catch (Exception $e) {
            self::loadView('error', ['message' => 'Could not delete file: ' . $e->getMessage()]);
        }
    }
} 