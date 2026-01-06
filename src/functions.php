<?php
// functions.php – utilitaires réutilisables

/**
 * Échappe une chaîne pour un affichage HTML sécurisé
 */
function e($s) {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
    // htmlspecialchars encode < > " ' &
}

/**
 * Génère un token CSRF sécurisé
 */
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        // random_bytes() génère une chaîne aléatoire sécurisée
        // bin2hex() la convertit en hexadécimal pour un usage HTML
    }
    return $_SESSION['csrf_token'];
}

/**
 * Vérifie la validité du token CSRF
 */
function verify_csrf_token($token) {
    return hash_equals($_SESSION['csrf_token'] ?? '', $token ?? '');
    // hash_equals() évite les attaques par timing
}

/**
 * Sécurise un nom de fichier
 */
function secure_filename($name) {
    // Conserve lettres, chiffres, points, tirets et underscores
    $name = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $name);
    return $name;
}
