<?php
if (!estConnecte() || !isset($_SESSION['idMedecin'])){
    include ("vues/v_connexion.php");
    return;
}
// id du medecin connecté qui est pris dans la session pas dans l'url
$id =(int) $_SESSION['idMedecin'];
// action demandé dans l'url 
$action = isset($_GET['action'])? $_GET['action'] : 'demande';

switch ($action){
   // Clic sur « Oui » : on crée le fichier JSON
   case 'generer': {
    // Seul un envoi de formulaire (POST) est accepté, pas un URL tapée
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('index.php?uc=portabilite');
        exit;
    }
    $donnees = $pdo->getDonneesMedecin($id);
    $resultat = ($donnees === null) ? null : genererFichierPortabilite($donnees, $id);
    include("vues/v_sommaire.php");
    if ($resultat===null){
        ajouterErreur("Impossible de générer vos données.");
        include ("vues/v_erreurs.php");
        include("vues/v_portabilite.php");
    }else{
        // reussite du coup lien de téléchargement + les empreintes a vérifier
        include ("vues/v_portabilite.php");
    }
    break;
}
case 'telecharge':{
     // Le fichier est celui de l'id en session : on ne peut pas prendre celui d'un autre
    $chemin = DOSSIER_PORTABILITE .'/'.$id . '.json';
    if (!is_file($chemin)) {
        http_response_code(404);
        exit('Fichier introuvable.');
    }

}
// Par défaut : page « Voulez-vous récupérer vos données ? » (Oui / Retour)
    default: {
        include("vues/v_sommaire.php");
        include("vues/v_portabilite.php");
        break;
    }
}