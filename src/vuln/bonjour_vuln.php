<?php
// bonjour_vuln.php
$nom = $_GET['nom'] ?? '';
$prenom = $_GET['prenom'] ?? '';
$repeter = $_GET['repeter'] ?? 1;
for ($i=0;$i<$repeter;$i++){
 echo "Bonjour $nom $prenom<br>";
}