<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controleur_connexion
 *
 * @author Luangpraseuth Alexis
 */
class ControleurConnexion {

    public function __construct() {
        
    }

    public function isConnected() {
        
        if (isset($_COOKIE['user'])) {
            return true;
        }
        return false;
    }

    public function isConnexionDepuisFormulaire() {
        if (isset($_POST['login']) && isset($_POST['passe']))
            return true;
        return false;
    }

    public function seConnecter() {
        if (self::isConnected()) {
            require_once chemins::CONTROLEURS . 'controleur_admin.class.php';
            $ControleurAdmin = new ControleurAdmin();
            if ($ControleurAdmin->isAdmin()) {
                $ControleurAdmin->afficherIndex();
            } else {
                require_once chemins::CONTROLEURS . 'controleur_accueil.class.php';
                $ControleurAccueil = new ControleurAccueil();
                $ControleurAccueil->afficherarticleAccueil();
            }
        } elseif (self::isConnexionDepuisFormulaire()) {
            require_once chemins::CONTROLEURS . "controleur_utilisateur.class.php";
            $Controleurutilisateur = new Controleurutilisateur();
            if($Controleurutilisateur->verifutilisateur(htmlspecialchars($_POST['login']),htmlspecialchars($_POST['passe']))){
                //var_dump(self::isConnected());
                //require_once chemins::CONTROLEURS . 'controleur_accueil.class.php';
                //$ControleurAccueil = new ControleurAccueil();
                //$ControleurAccueil->afficherarticleAccueil();
                 header("Location: /index.php");
            }   
        } else {
            require_once chemins::VUES_ADMIN . "v_connexion.inc.php";
        }
    }

    public function seDeconnecter() {
        setcookie('user', '', time() - 3600, '/');
        // Suppression de la valeur du cookie en mémoire dans $_COOKIE
        unset($_COOKIE['user']);
    }

}
