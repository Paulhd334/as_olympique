<?php
// upload_secure.php — version sécurisée (BLOC 3)

// Taille maximale : 2 Mo
$maxSize = 2 * 1024 * 1024;

// Extensions autorisées (whitelist)
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérifier présence du fichier
    if (!isset($_FILES['photo'])) {
        echo "Aucun fichier envoyé";
        exit;
    }

    // Vérifier erreur PHP
    if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        echo "Erreur lors de l'upload";
        exit;
    }

    // Vérifier taille
    if ($_FILES['photo']['size'] > $maxSize) {
        echo "Fichier trop volumineux";
        exit;
    }

    // Récupérer extension
    $originalName = $_FILES['photo']['name'];
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    // Rejeter fichiers exécutables
    $forbiddenExtensions = ['php', 'phtml', 'php3', 'pl', 'sh'];
    if (in_array($extension, $forbiddenExtensions)) {
        echo "Fichier exécutable interdit";
        exit;
    }

    // Vérifier extension autorisée
    if (!in_array($extension, $allowedExtensions)) {
        echo "Extension interdite";
        exit;
    }

    // Renommer fichier
    $newName = bin2hex(random_bytes(12)) . '.' . $extension;

    // Dossier sécurisé
    $uploadDir = __DIR__ . '/../../uploads_secure/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Déplacer fichier
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $newName)) {
        echo "Upload sécurisé OK : " . htmlspecialchars($newName);
    } else {
        echo "Échec de l'upload";
    }

    exit;
}
?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="photo" required>
    <button>Envoyer (secure)</button>
</form>
