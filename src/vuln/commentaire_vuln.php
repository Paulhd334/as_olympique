<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $membre_id = $_POST['membre_id'] ?? 1;
    $contenu = $_POST['contenu'] ?? '';

    $sql = "INSERT INTO commentaires (membre_id, contenu)
            VALUES ($membre_id, '$contenu')";
    $pdo->exec($sql);

    echo "Commentaire posté (vuln)";
    exit;
}

$stmt = $pdo->query("SELECT * FROM commentaires LIMIT 20");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<form method="post">
    <textarea name="contenu"></textarea><br>
    <button>Poster (vuln)</button>
</form>

<?php
foreach ($rows as $r) {
    echo "<div><strong>Par {$r['membre_id']}</strong> : {$r['contenu']}</div>";
}
?>
