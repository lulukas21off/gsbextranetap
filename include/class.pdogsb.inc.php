<?php

/**
 * Classe d'accès aux données.
 * Utilise les services de la classe PDO pour l'application GSB.
 *
 * @package default
 * @author Cheri Bibi
 * @version 1.0
 * @link http://www.php.net/manual/fr/book.pdo.php
 */
class PdoGsb {
    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=gsbextranet';
    private static $user = 'gsbextranetAdmin';
    private static $mdp = 'Mdprobuste1';
    private static $monPdo;
    private static $monPdoGsb = null;

    private function __construct() {
        PdoGsb::$monPdo = new PDO(PdoGsb::$serveur . ';' . PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
        PdoGsb::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // AJOUT
        PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
    }

    public function _destruct() {
        PdoGsb::$monPdo = null;
    }

    public static function getPdoGsb() {
        if (PdoGsb::$monPdoGsb == null) {
            PdoGsb::$monPdoGsb = new PdoGsb();
        }
        return PdoGsb::$monPdoGsb;
    }

    function checkUser($login, $pwd): bool {
        $user = false;
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT motDePasse FROM medecin WHERE mail= :login AND token IS NULL");
        $monObjPdoStatement->bindValue(':login', $login, PDO::PARAM_STR);
        if ($monObjPdoStatement->execute()) {
            $unUser = $monObjPdoStatement->fetch();
            if (is_array($unUser)) {
                if (password_verify($pwd, $unUser['motDePasse']))
                    $user = true;
            }
        } else
            throw new Exception("erreur dans la requête");
        return $user;
    }

    function donneLeMedecinByMail($login) {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT id, nom, prenom, mail FROM medecin WHERE mail= :login");
        $monObjPdoStatement->bindValue(':login', $login, PDO::PARAM_STR);
        if ($monObjPdoStatement->execute()) {
            $unUser = $monObjPdoStatement->fetch();
        } else
            throw new Exception("erreur dans la requête");
        return $unUser;
    }

    public function tailleChampsMail() {
        $pdoStatement = PdoGsb::$monPdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = 'medecin' AND COLUMN_NAME = 'mail'");
        $pdoStatement->execute();
        $leResultat = $pdoStatement->fetch();
        return $leResultat[0];
    }

    /**
     * Crée le médecin ET enregistre son consentement (même transaction).
     */
    public function creeMedecin($email, $mdp,$prenom,$nom) {
        try {
            PdoGsb::$monPdo->beginTransaction();

            $pdoStatement = PdoGsb::$monPdo->prepare(
                "INSERT INTO medecin(nom,prenom, mail, motDePasse, dateCreation) "
                . "VALUES (:leNom,:lePrenom, :leMail, :leMdp, now())");
            $pdoStatement->bindValue(':leMail', $email);
            $pdoStatement->bindValue(':leMdp', $mdp);
            $pdoStatement->bindValue(':lePrenom',$prenom);
            $pdoStatement->bindValue(':leNom',$nom);

            if (!$pdoStatement->execute()) {
                PdoGsb::$monPdo->rollBack();
                return false;
            }

            $idMedecin = (int) PdoGsb::$monPdo->lastInsertId();
            $this->ajouterConsentement($idMedecin, $this->getVersionCourante());

            PdoGsb::$monPdo->commit();
            return true;
        } catch (PDOException $e) {
            if (PdoGsb::$monPdo->inTransaction()) {
                PdoGsb::$monPdo->rollBack();
            }
            return false;
        }
    }

    public function getVersionCourante(): int {
        $req = PdoGsb::$monPdo->prepare(
            "SELECT id FROM politique_version
             WHERE dateDebutValidite <= CURDATE()
               AND (dateFinValidite IS NULL OR dateFinValidite >= CURDATE())
             ORDER BY dateDebutValidite DESC LIMIT 1");
        $req->execute();
        return (int) $req->fetchColumn();
    }

    public function getDerniereVersionAcceptee(int $idMedecin): int {
        $req = PdoGsb::$monPdo->prepare(
            "SELECT idVersion FROM consentement
             WHERE idMedecin = :id ORDER BY dateConsentement DESC LIMIT 1");
        $req->bindValue(':id', $idMedecin, PDO::PARAM_INT);
        $req->execute();
        return (int) $req->fetchColumn();
    }

    public function ajouterConsentement(int $idMedecin, int $idVersion): void {
        $req = PdoGsb::$monPdo->prepare(
            "INSERT INTO consentement (idMedecin, idVersion) VALUES (:idM, :idV)");
        $req->bindValue(':idM', $idMedecin, PDO::PARAM_INT);
        $req->bindValue(':idV', $idVersion, PDO::PARAM_INT);
        $req->execute();
    }

    function testMail($email) {
        $pdo = PdoGsb::$monPdo;
        $pdoStatement = $pdo->prepare("SELECT count(*) as nbMail FROM medecin WHERE mail = :leMail");
        $pdoStatement->bindValue(':leMail', $email);
        $pdoStatement->execute();
        $resultatRequete = $pdoStatement->fetch();
        return ($resultatRequete['nbMail'] != 0);
    }

    function connexionInitiale($mail) {
        $medecin = $this->donneLeMedecinByMail($mail);
        $id = $medecin['id'];
        $this->ajouteConnexionInitiale($id);
    }

    function ajouteConnexionInitiale($id) {
        $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO historiqueconnexion "
            . "VALUES (:leMedecin, now(), now())");
        $pdoStatement->bindValue(':leMedecin', $id);
        return $pdoStatement->execute();
    }

    function donneinfosmedecin($id) {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT id,nom,prenom FROM medecin WHERE id= :lId");
        $monObjPdoStatement->bindValue(':lId', $id, PDO::PARAM_INT);
        if ($monObjPdoStatement->execute()) {
            $unUser = $monObjPdoStatement->fetch();
        } else
            throw new Exception("erreur");
        return $unUser;
    }
    public function getDonneesMedecin(int $id) {
        $req = PdoGsb::$monPdo->prepare("SELECT * FROM medecin WHERE id = :lId");
        $req->bindValue(':lId', $id, PDO::PARAM_INT);
        $req->execute();
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false) {
            return null;
        }
        unset($donnees['id'], $donnees['motDePasse']);
        return $donnees;
    }
}
?>
?>