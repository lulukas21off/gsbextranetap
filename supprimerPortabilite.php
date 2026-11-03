<?php
// Script lancé par le planificateur de tâches (ligne de commande uniquement, pas depuis le navigateur)
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Accès interdit.');
}

require_once __DIR__ . '/include/fct.inc.php';

// __DIR__ : chemin absolu, le script marche quel que soit le dossier d'où il est lancé
$dossier = __DIR__ . '/portabilite';

$fichiers = getFichiersPortabilite($dossier);
$nb = supprimerFichiers($fichiers);

echo date('Y-m-d H:i:s') . " : $nb fichier(s) json supprimé(s) sur " . count($fichiers) . ".\n";