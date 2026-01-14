<?php
// upload_secure.php — version sécurisée

$maxSize = 2 * 1024 * 1024; // 2 Mo
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['photo'])) {
        echo "Aucun fichier envoyé";
        exit;
    }

    // Vérification erreur upload
    if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        echo "Erreur lors de l'upload";
        exit;
    }

    // Vérification taille
    if ($_FILES['photo']['size'] > $maxSize) {
        echo "Fichier trop volumineux";
        exit;
    }

    // Extension
    $originalName = $_FILES['photo']['name'];
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExtensions)) {
        echo "Extension interdite";
        exit;
    }

    // Vérification MIME réel
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['photo']['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowedMimeTypes)) {
        echo "Type MIME invalide";
        exit;
    }

    // Nouveau nom aléatoire
    $newName = bin2hex(random_bytes(12)) . '.' . $ext;

    // Dossier d’upload (idéalement hors webroot)
    $uploadDir = __DIR__ . '/../../uploads_secure/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Déplacement sécurisé
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
