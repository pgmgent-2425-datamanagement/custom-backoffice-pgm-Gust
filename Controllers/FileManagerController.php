<?php

namespace App\Controllers;

class FileManagerController extends BaseController {
    public static function index() {
        $dir = __DIR__ . '/../public/uploads/';
        $files = [];
        if (is_dir($dir)) {
            foreach (scandir($dir) as $file) {
                if ($file !== '.' && $file !== '..') {
                    $files[] = $file;
                }
            }
        }
        self::loadView('filemanager/index', ['files' => $files]);
    }

    public static function delete($filename) {
        $file = basename($filename); // beveiliging tegen path traversal
        $path = __DIR__ . '/../public/uploads/' . $file;
        if (is_file($path)) {
            unlink($path);
        }
        header('Location: /filemanager');
        exit;
    }
} 