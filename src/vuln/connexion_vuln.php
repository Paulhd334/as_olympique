<?php
require __DIR__ . '/../init.php';
// vuln : concaténation SQL
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username = $_POST['username'] ?? '';

 $password = $_POST['password'] ?? '';
 $sql = "SELECT * FROM users WHERE username = '$username' AND password_hash =
'$password'"; // hache le mot de passe
 $res = $pdo->query($sql);
 $user = $res->fetch();
 if ($user) {
 echo "Connecté en tant que " . htmlspecialchars($user['username']);
// htmlspecialchars encode <,>,",',&.
 } else {
 echo "Erreur login";
 }
 exit;
}
?>
<form method="post">
 <input name="username" placeholder="username"><br>
 <input name="password" placeholder="password"><br>
 <button>Connexion vuln</button>
</form>
