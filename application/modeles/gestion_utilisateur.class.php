<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gestion_utilisateur
 *
 * @author Luangpraseuth Alexis
 */
class Gestionutilisateur extends GestionBDD {

    public static function getutilisateur($login, $passe){
      $champs = array("login","passe");
      $valeurChamps = array($login,sha1($passe));
      return parent::getLeTupleByChamp('utilisateur', $champs, $valeurChamps);
    }

    public static function getutilisateurById($id){
        return parent::getLeTupleByChamp('utilisateur',"idutilisateur", $id);
    }


    public static function isUserOK($login, $pass) {
        self::seConnecter();
        try
        {
            self::$request = "SELECT * From utilisateur where login=:login and passe=:pass";
            self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
            self::$pdoStResults->bindValue('login', $login);
            self::$pdoStResults->bindValue('pass', sha1($pass));
            self::$pdoStResults->execute();
            self::$result = self::$pdoStResults->fetch();
            self::$pdoStResults->closeCursor();

            if ((self::$result != null) and self::$result->isAdmin)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        catch (Exception $exc)
        {
            echo $exc->getMessage();
        }
    }

    /**
     * Ajoute un utilisateur à la BDD
     * @param type nom de l'utilisateur
     * @param type prenom de l'utilisateur
     * @param type email de l'utilisateur
     * @param type admin ou non
     * @param type speudo de l'utilisateur
     * @param type passe de l'utilisateur
     */
    public static function ajouterutilisateur($nom,$prenom,$email, $admin,$login,$passe) {
        $utilisateur = array(
            "idutilisateur" => self::genererClePrimaire("idutilisateur",'utilisateur'),
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $email,
            "admin" => $admin,
            "login" => $login,
            "passe" => sha1($passe)
        );
        parent::modifTable("insert",$utilisateur, 'utilisateur');
    }




    /**
    * Modifie un utilisateur à la BDD
    * @param type id de l'utilisateur
    * @param type nom de l'utilisateur
    * @param type prenom de l'utilisateur
    * @param type email de l'utilisateur
    * @param type admin ou non
    * @param type speudo de l'utilisateur
    * @param type passe de l'utilisateur
     */
    public static function modifierutilisateur($id,$nom,$prenom,$email, $admin,$login,$passe) {
        self :: seConnecter();
        try {
            self::$request = "UPDATE utilisateur SET  nom=:nom, prenom= :prenom, email= :email, admin= :admin,login= :login, passe= :passe WHERE idutilisateur= :idutilisateur";
            self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
            self::$pdoStResults->bindValue('idutilisateur', $id);
            self::$pdoStResults->bindValue('nom', $nom);
            self::$pdoStResults->bindValue('prenom', $prenom);
            self::$pdoStResults->bindValue('email', $email);
            self::$pdoStResults->bindValue('admin', $admin);
            self::$pdoStResults->bindValue('login', $idcreateure);
            self::$pdoStResults->bindValue('passe', sha1($passe));
            self::$pdoStResults->execute();
        } catch (Exception $ex) {
            echo 'Erreur : ' . $ex->getMessage();
        }
    }



}
