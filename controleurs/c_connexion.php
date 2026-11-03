<?php


if(!isset($_GET['action'])){
	$_GET['action'] = 'demandeConnexion';
}
$action = $_GET['action'];
switch($action){
	
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
		$login = $_POST['login'];
		$mdp = $_POST['mdp'];
		$connexionOk = $pdo->checkUser($login,$mdp);
		if(!$connexionOk){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		else { 
			$infosMedecin = $pdo->donneLeMedecinByMail($login);
			$id = $infosMedecin['id'];
			$nom =  $infosMedecin['nom'];
			$prenom = $infosMedecin['prenom'];
			connecter($id,$nom,$prenom);

			// Vérification de la version de la politique acceptée
			$_SESSION['idMedecin'] = $id;
			$versionCourante = $pdo->getVersionCourante();
			$_SESSION['politiqueAJour'] =
				($versionCourante > 0 && $pdo->getDerniereVersionAcceptee($id) === $versionCourante);

			include("vues/v_sommaire.php");
			if (!$_SESSION['politiqueAJour']) {
				include("vues/v_popup_politique.php");
			}
		}
		break;	
	}

	case 'majConsentement':{
		if (!isset($_SESSION['idMedecin'])) {
			include("vues/v_connexion.php");
			break;
		}
		if (($_POST['choix'] ?? '') === 'accepter') {
			$pdo->ajouterConsentement((int) $_SESSION['idMedecin'], $pdo->getVersionCourante());
			$_SESSION['politiqueAJour'] = true;
			include("vues/v_sommaire.php");
		} else {
			session_unset();
			session_destroy();
			ajouterErreur("Vous devez accepter la nouvelle politique pour utiliser l'application.");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		break;
	}
        
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>