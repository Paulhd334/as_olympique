<?php
// bonjour_secure.php - Version sécurisée
require_once __DIR__ . '/../init.php';
require_once __DIR__ . '/../functions.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bonjour - Sécurisé</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Formulaire Bonjour (Sécurisé)</h1>
    
    <form method="GET" action="">
        <label>Nom:</label>
        <input type="text" name="nom" pattern="[A-Za-zÀ-ÿ\s\-]{1,50}" 
               title="Lettres, espaces et tirets uniquement (max 50 caractères)" 
               value="<?= e($_GET['nom'] ?? '') ?>">
        <br><br>
        
        <label>Prénom:</label>
        <input type="text" name="prenom" pattern="[A-Za-zÀ-ÿ\s\-]{1,50}"
               title="Lettres, espaces et tirets uniquement (max 50 caractères)"
               value="<?= e($_GET['prenom'] ?? '') ?>">
        <br><br>
        
        <label>Répétitions:</label>
        <input type="number" name="repeter" min="1" max="20" 
               value="<?= e($_GET['repeter'] ?? 1) ?>">
        <small>(1-20 maximum)</small>
        <br><br>
        
        <button type="submit">Afficher</button>
    </form>
    
    <hr>
    
    <?php
    // VALIDATION DES DONNÉES
    $errors = [];
    
    // Validation du nom
    $nom = trim($_GET['nom'] ?? '');
    if (!empty($nom)) {
        if (!preg_match('/^[A-Za-zÀ-ÿ\s\-]{1,50}$/u', $nom)) {
            $errors[] = "Nom invalide (caractères autorisés: lettres, espaces, tirets)";
        }
    }
    
    // Validation du prénom
    $prenom = trim($_GET['prenom'] ?? '');
    if (!empty($prenom)) {
        if (!preg_match('/^[A-Za-zÀ-ÿ\s\-]{1,50}$/u', $prenom)) {
            $errors[] = "Prénom invalide (caractères autorisés: lettres, espaces, tirets)";
        }
    }
    
    // Validation et sanitization des répétitions
    $repeter = $_GET['repeter'] ?? 1;
    $repeter = filter_var($repeter, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 20]
    ]);
    
    if ($repeter === false) {
        $repeter = 1; // Valeur par défaut
        $errors[] = "Nombre de répétitions invalide (1-20)";
    }
    
    // AFFICHAGE DES ERREURS
    if (!empty($errors)) {
        echo '<div class="error"><strong>Erreurs:</strong><ul>';
        foreach ($errors as $error) {
            echo '<li>' . e($error) . '</li>';
        }
        echo '</ul></div>';
    }
    
    // AFFICHAGE DES RÉSULTATS (SÉCURISÉ)
    if (!empty($nom) || !empty($prenom)) {
        echo '<h2>Résultats:</h2>';
        echo '<div class="success">';
        
        // ÉCHAPPEMENT HTML pour prévenir XSS
        $nom_safe = e($nom);
        $prenom_safe = e($prenom);
        
        for ($i = 0; $i < $repeter; $i++) {
            echo "Bonjour $nom_safe $prenom_safe<br>";
        }
        
        echo '</div>';
        
        // Journalisation (optionnel)
        error_log("Bonjour appelé: nom=$nom, prenom=$prenom, repeter=$repeter");
    }
    ?>
    
    <hr>
    <p><a href="../index.php">Retour au menu</a></p>
</body>
</html>