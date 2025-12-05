<?php

//Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'hasta_db');
define('DB_USER', 'root');
define('DB_PASS', '');

//Base URL - automatically detect with project folder
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

// Get the script path and extract the project folder
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$scriptDir = dirname($scriptName);

// Handle cases where script is in /public subfolder
if (basename($scriptDir) === 'public') {
    $base_path = dirname($scriptDir); // Go up one level from /public
} else {
    $base_path = $scriptDir;
}

// Clean up the path (remove trailing slashes, handle root)
$base_path = rtrim($base_path, '/');
if ($base_path === '' || $base_path === '.') {
    $base_path = '';
}

define('BASE_URL', $protocol . '://' . $host . $base_path);

//Start the session
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

?>