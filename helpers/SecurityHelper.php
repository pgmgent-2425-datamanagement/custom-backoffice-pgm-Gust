<?php

namespace App\Helpers;

class SecurityHelper {
    
    /**
     * Generate CSRF token
     */
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validate CSRF token
     */
    public static function validateCSRFToken($token) {
        if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            return false;
        }
        return true;
    }
    
    /**
     * Sanitize and validate string input
     */
    public static function sanitizeString($input, $maxLength = 255) {
        if (empty($input)) {
            return null;
        }
        
        $input = trim($input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        
        if (strlen($input) > $maxLength) {
            return null;
        }
        
        return $input;
    }
    
    /**
     * Sanitize and validate email
     */
    public static function sanitizeEmail($email) {
        if (empty($email)) {
            return null;
        }
        
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }
        
        return $email;
    }
    
    /**
     * Sanitize and validate integer
     */
    public static function sanitizeInt($input, $min = null, $max = null) {
        if (!is_numeric($input)) {
            return null;
        }
        
        $input = (int) $input;
        
        if ($min !== null && $input < $min) {
            return null;
        }
        
        if ($max !== null && $input > $max) {
            return null;
        }
        
        return $input;
    }
    
    /**
     * Sanitize and validate date
     */
    public static function sanitizeDate($date) {
        if (empty($date)) {
            return null;
        }
        
        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return null;
        }
        
        return date('Y-m-d', $timestamp);
    }
    
    /**
     * Validate file upload
     */
    public static function validateFileUpload($file, $allowedTypes = [], $maxSize = 5242880) {
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return ['valid' => true, 'filename' => null];
        }
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['valid' => false, 'error' => 'Upload error: ' . $file['error']];
        }
        
        if ($file['size'] > $maxSize) {
            return ['valid' => false, 'error' => 'File too large. Maximum size: ' . ($maxSize / 1024 / 1024) . 'MB'];
        }
        
        if (!empty($allowedTypes)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
            
            if (!in_array($mimeType, $allowedTypes)) {
                return ['valid' => false, 'error' => 'Invalid file type. Allowed: ' . implode(', ', $allowedTypes)];
            }
        }
        
        return ['valid' => true, 'filename' => $file['name']];
    }
    
    /**
     * Generate safe filename
     */
    public static function generateSafeFilename($originalName, $prefix = 'file_') {
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $safeExt = preg_replace('/[^a-z0-9]/', '', $ext);
        
        if (empty($safeExt)) {
            $safeExt = 'bin';
        }
        
        return $prefix . uniqid('', true) . '.' . $safeExt;
    }
}
