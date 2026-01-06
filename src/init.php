<?php
// init.php - démarre session et PDO
$config = require __DIR__ . '/config.php';

// session cookie params
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

// Connexion PDO avec port MAMP
try {
    $dsn = "mysql:host={$config->db->host};port={$config->db->port};dbname={$config->db->dbname};charset={$config->db->charset}";
    
    $pdo = new PDO($dsn, $config->db->user, $config->db->pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo "Erreur de connexion DB: " . htmlspecialchars($e->getMessage());
    exit;
}