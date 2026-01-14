<?php
// config.php - paramètres de connexion et config globale
return (object)[
    'db' => (object)[
        'host' => 'localhost',
       'port' => 3306, // Port MySQL MAMP

        'dbname' => 'as_olympique_db',
        'user' => 'root', // Compte spécifique pour l'appli
        'pass' => 'root',
        'charset' => 'utf8mb4'
    ],
    // chemin vers uploads 
    'upload_dir' => __DIR__ . '/../uploads/',
    'max_upload_size' => 2 * 1024 * 1024 // 2MB
];