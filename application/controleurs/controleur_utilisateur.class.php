<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controleur_utilisateur
 *
 * @author Luangpraseuth Alexis
 */
class Controleurutilisateur {
    public function __construct() {
        
    }
    
    public function ajouterutilisateur(){
         Gestionutilisateur::ajouterutilisateur(htmlspecialchars($_POST['nom']),htmlspecialchars($_POST['prenom']),htmlspecialchars($_POST['email']),'false',htmlspecialchars($_POST['login']),htmlspecialchars($_POST['passe']) );
        require_once chemins::CONTROLEURS . 'controleur_connexion.class.php';
            $ControleurConnexion = new ControleurConnexion();
            $ControleurConnexion->seConnecter();
    }
    
    public function inscription(){
       require chemins::VUES . 'v_inscription.inc.php';
    }
    
    public function verifutilisateur($login, $passe){
        $utilisateur = Gestionutilisateur::getutilisateur($login,$passe);
        if($utilisateur != null){
              $token = ["idUser" => $utilisateur->idutilisateur,
                  "login"  => $utilisateur->login,
                  "isAdmin" => $utilisateur->admin
                  ];
        $jwt = JWT::encode($token, VariablesGlobales::KEY);
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        setcookie("user", $jwt , time() + (86400 * 30), "/",$domain,false,true);
            return true;
        }
        return false;
    }
}