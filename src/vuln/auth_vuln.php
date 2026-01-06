<?php
require __DIR__ . '/../init.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 // authentification rapide (vuln)
 $user = $_POST['user'] ?? '';
 $_SESSION['user'] = $user; // pas de régénération
 header('Location: ../index.php');
 exit;
}
?>
<form method="post"><input name="user"><button>Login
vuln</button></form>