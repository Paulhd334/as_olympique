src/vuln/upload_vuln.php
<?php
// upload_vuln.php - très simplifié et dangereux, pour exercice
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 if (isset($_FILES['photo'])) { // pour s’assurer qu’un fichier a été soumis
 move_uploaded_file($_FILES['photo']['tmp_name'], __DIR__ . '/../../uploads/' .
$_FILES['photo']['name']);
// move_uploaded_file() — sécurité native pour uploads temporaires
 echo "Upload OK: " . $_FILES['photo']['name'];

  } else {
 echo "Aucun fichier";
 }
 exit;
}
?>
<form method="post" enctype="multipart/form-data">
 <input type="file" name="photo">
 <button>Envoyer (vuln)</button>
</form>