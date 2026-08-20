<?php
/**
 * Panchalbhumi FPC - Configuration File
 * Database and Application Settings
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'panchalbhumi_fpc');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_CHARSET', 'utf8mb4');

// Site Configuration
define('SITE_NAME', 'Panchalbhumi Farmers Producer Company Limited');
define('SITE_SHORT_NAME', 'Panchalbhumi FPC');
define('SITE_URL', 'http://localhost/panchalbhumi-fpc/');
define('ADMIN_URL', SITE_URL . 'admin/');
define('SITE_DESCRIPTION', 'Professional Farmer Producer Organization Website');

// Security
define('SECRET_KEY', 'your-secret-key-change-this-in-production');
define('SESSION_TIMEOUT', 3600); // 1 hour in seconds
define('ADMIN_SESSION_TIMEOUT', 7200); // 2 hours

// Upload Configuration
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/uploads/');
define('UPLOAD_TEMP_DIR', UPLOAD_DIR . 'temp/');
define('MAX_FILE_SIZE', 10485760); // 10 MB
define('MAX_IMAGE_SIZE', 5242880); // 5 MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp']);
define('ALLOWED_DOCUMENT_TYPES', ['application/pdf']);
define('ALLOWED_IMAGE_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp']);
define('ALLOWED_DOCUMENT_EXTENSIONS', ['pdf']);

// Image Settings
define('THUMBNAIL_WIDTH', 300);
define('THUMBNAIL_HEIGHT', 300);
define('HERO_IMAGE_WIDTH', 1920);
define('HERO_IMAGE_HEIGHT', 600);

// Pagination
define('ITEMS_PER_PAGE', 12);
define('ADMIN_ITEMS_PER_PAGE', 20);

// Email Configuration
define('FROM_EMAIL', 'info@panchalbhumi.local');
define('FROM_NAME', 'Panchalbhumi FPC');
define('ADMIN_EMAIL', 'admin@panchalbhumi.local');

// API Settings
define('API_RATE_LIMIT', 100); // requests per hour

// Development/Production
define('ENVIRONMENT', 'development'); // 'development' or 'production'

if (ENVIRONMENT == 'production') {
    ini_set('display_errors', 0);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Enable error logging
error_log('Panchalbhumi FPC - ' . date('Y-m-d H:i:s'), 3, dirname(__DIR__) . '/logs/error.log');

?>