<?php
require __DIR__ . '/../init.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 $membre_id = $_POST['membre_id'] ?? 1;
 $contenu = $_POST['contenu'] ?? '';
  // insertion vulnérable (no sanit)

$pdo->exec("INSERT INTO commentaires (membre_id, contenu) VALUES
($membre_id, '" . str_replace("'", "''", $contenu) . "')");
 echo "Commentaire posté (vuln)";
 exit;
}
// affichage vulnérable
$stmt = $pdo->query("SELECT c.* FROM commentaires c ORDER BY date_post DESC
LIMIT 20");
$rows = $stmt->fetchAll();
?>
<form method="post">
 <textarea name="contenu"></textarea><br>
 <button>Poster (vuln)</button>
</form>
<?php foreach($rows as $r){ echo "<div><strong>Par ".$r['membre_id']."</strong>:
".$r['contenu']."</div>"; } ?>
