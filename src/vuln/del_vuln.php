<?php
require __DIR__ . '/../init.php';
$id = $_GET['id'] ?? '';
// suppression par GET (vuln CSRF)
if ($id) {
 $pdo->exec("DELETE FROM inscriptions WHERE id = " . intval($id));
 echo "Supprimé";
} else {
 echo "pas d'id";
}