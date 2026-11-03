<?php
require_once __DIR__ . '/../include/fct.inc.php';

// dossier temporaire avec 3 json et 1 txt
$dossier = sys_get_temp_dir() . '/test_portabilite_' . uniqid();
mkdir($dossier);
foreach (array('1.json', '2.json', '3.json', 'garder.txt') as $f) {
    file_put_contents("$dossier/$f", 'x');
}

$fichiers = getFichiersPortabilite($dossier);
echo count($fichiers) === 3 ? "OK  : 3 json trouvés\n" : "ERREUR : json trouvés = " . count($fichiers) . "\n";

$nb = supprimerFichiers($fichiers);
echo $nb === 3 ? "OK  : 3 json supprimés\n" : "ERREUR : supprimés = $nb\n";

echo count(getFichiersPortabilite($dossier)) === 0 ? "OK  : plus aucun json\n" : "ERREUR : il reste des json\n";
echo is_file("$dossier/garder.txt") ? "OK  : le .txt est conservé\n" : "ERREUR : le .txt a été supprimé\n";

// nettoyage
unlink("$dossier/garder.txt");
rmdir($dossier);