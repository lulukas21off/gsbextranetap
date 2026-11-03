<?php
const DOSSIER_PORTABILITE = 'portabilite';
const ALGO_EMPREINTE = 'sha256';
//on insère le fichier qui contient les fonctions


 /**
 * Teste si un quelconque visiteur est connecté
 * @return vrai ou faux 
 */
function estConnecte(){
  return isset($_SESSION['id']);
}
/**
 * Enregistre dans une variable session les infos d'un visiteur
 
 * @param $id 
 * @param $nom
 * @param $prenom
 */
function connecter($id,$nom,$prenom){
	$_SESSION['id']= $id; 
	$_SESSION['nom']= $nom;
	$_SESSION['prenom']= $prenom;
}


/* gestion des erreurs*/
/**
 * Indique si une valeur est un entier positif ou nul
 
 * @param $valeur
 * @return vrai ou faux
*/
function estEntierPositif($valeur) {
	return preg_match("/[^0-9]/", $valeur) == 0;
	
}

/**
 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls
 
 * @param $tabEntiers : le tableau
 * @return vrai ou faux
*/
function estTableauEntiers($tabEntiers) {
	$ok = true;
	if (isset($unEntier) ){
		foreach($tabEntiers as $unEntier){
			if(!estEntierPositif($unEntier)){
		 		$ok=false; 
			}
		}	
	}
	return $ok;
}

/**
 * Ajoute le libellé d'une erreur au tableau des erreurs 
 
 * @param $msg : le libellé de l'erreur 
 */
function ajouterErreur($msg){
   if (! isset($_REQUEST['erreurs'])){
      $_REQUEST['erreurs']=array();
	} 
   $_REQUEST['erreurs'][]=$msg;
}
/**
 * Retoune le nombre de lignes du tableau des erreurs 
 
 * @return le nombre d'erreurs
 */
function nbErreurs(){
   if (!isset($_REQUEST['erreurs'])){
	   return 0;
	}
	else{
	   return count($_REQUEST['erreurs']);
	}
}


function input_data($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;

}


    
    function generateCode(){
          // Generate a 6 digits hexadecimal number
	  $numbytes = 3; // Because 6 digits hexadecimal = 3 bytes
	  $bytes = openssl_random_pseudo_bytes($numbytes); 
          $hex   = bin2hex($bytes);
	  return $hex;
        
    }
/**
 * Génère le JSON, écrit le fichier physique id.json dans le dossier portabilite
 * et retourne le nom du fichier, l'algorithme et l'empreinte (intégrité), ou null en cas d'échec.
 */
function genererFichierPortabilite($donnees, $id) {
    $json = json_encode($donnees, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return null;
    }
    if (!is_dir(DOSSIER_PORTABILITE)) {
        mkdir(DOSSIER_PORTABILITE, 0750, true);
    }
    $chemin = DOSSIER_PORTABILITE . '/' . (int) $id . '.json';
    if (file_put_contents($chemin, $json, LOCK_EX) === false) {
        return null;
    }
    return array(
        'fichier'   => (int) $id . '.json',
        'algo'      => strtoupper(ALGO_EMPREINTE),
        'empreinte' => hash_file(ALGO_EMPREINTE, $chemin)
    );
}

// Retourne la liste des fichiers .json d'un dossier (chemins complets)
function getFichiersPortabilite($dossier) {
    $fichiers = array();
    foreach (scandir($dossier) as $nom) {
        $chemin = $dossier . '/' . $nom;
        // on ne garde que les vrais fichiers .json (pas . / .. / .htaccess)
        if (is_file($chemin) && strtolower(pathinfo($nom, PATHINFO_EXTENSION)) === 'json') {
            $fichiers[] = $chemin;
        }
    }
    return $fichiers;
}

// Supprime les fichiers donnés, retourne le nombre de fichiers supprimés
function supprimerFichiers($fichiers) {
    $nb = 0;
    foreach ($fichiers as $fichier) {
        if (unlink($fichier)) {
            $nb++;
        }
    }
    return $nb;
}

    
    
    
?>