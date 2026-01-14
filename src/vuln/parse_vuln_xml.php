<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// chemin ABSOLU sécurisé
$xmlFile = __DIR__ . '../../../menu_vuln.xml';

if (!file_exists($xmlFile)) {
    die("❌ Fichier XML introuvable : $xmlFile");
}

$xml = file_get_contents($xmlFile);
if ($xml === false) {
    die("❌ Impossible de lire le fichier XML");
}

libxml_use_internal_errors(true);

$dom = new DOMDocument();
$dom->loadXML($xml, LIBXML_NOENT | LIBXML_DTDLOAD); // ⚠️ volontairement vulnérable XXE

echo "<pre>" . htmlspecialchars($dom->saveXML()) . "</pre>";

if ($errors = libxml_get_errors()) {
    echo "<pre>Erreurs XML:\n";
    foreach ($errors as $e) {
        echo $e->message;
    }
    echo "</pre>";
}
