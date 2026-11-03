<?php
echo "<h2>Portabilité de vos données</h2>";

// Cas 1 : le fichier n'est pas encore généré -> on pose la question
if (empty($resultat)) {
    echo "<p>Voulez-vous récupérer vos données personnelles ?</p>";
    echo "<form method=\"post\" action=\"index.php?uc=portabilite&amp;action=generer\" style=\"display:inline\">";
    echo "<button type=\"submit\">Oui</button>";
    echo "</form> ";
    echo "<a href=\"index.php\"><button type=\"button\">Retour</button></a>";
}
// Cas 2 : le fichier est généré -> lien de téléchargement + empreinte
else {
    $fichier = htmlspecialchars($resultat['fichier']);
    $algo = htmlspecialchars($resultat['algo']);
    $empreinte = htmlspecialchars($resultat['empreinte']);

    echo "<p>Vos données sont prêtes : ";
    echo "<a href=\"index.php?uc=portabilite&amp;action=telecharger\">Télécharger $fichier</a></p>";

    echo "<h3>Vérifier l'intégrité du fichier</h3>";
    echo "<p>Empreinte <strong>$algo</strong> du fichier :</p>";
    echo "<pre>$empreinte</pre>";

    echo "<p>Après téléchargement, calculez l'empreinte de votre copie et comparez-la à celle ci-dessus :<br>";
    echo "Linux/macOS : <code>sha256sum $fichier</code><br>";
    echo "Windows : <code>certutil -hashfile $fichier SHA256</code><br>";
    echo "Si les deux valeurs diffèrent, le fichier a été altéré (transfert corrompu ou modification) : ne l'utilisez pas.</p>";

    echo "<a href=\"index.php\"><button type=\"button\">Retour</button></a>";
}
?>

