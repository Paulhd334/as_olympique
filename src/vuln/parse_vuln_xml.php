<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// parse_vuln_xml.php

$xmlPath = __DIR__ . '/menu_vuln.xml';

if (!file_exists($xmlPath)) {
    die('Fichier XML introuvable : ' . $xmlPath);
}

$xml = file_get_contents($xmlPath);
if ($xml === false || trim($xml) === '') {
    die('XML vide ou illisible');
}

libxml_use_internal_errors(true);

$dom = new DOMDocument();

// Sécurisation XXE
if (!$dom->loadXML($xml, LIBXML_NONET)) {
    die('Erreur de parsing XML');
}

echo '<pre>';
echo htmlspecialchars($dom->saveXML(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
echo '</pre>';
