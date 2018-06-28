<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controleur_admin
 *
 * @author Luangpraseuth Alexis
 */
class ControleurAdmin {

    public function __construct() {
        
    }

    public function isAdmin() {
        require_once chemins::CONTROLEURS . 'controleur_connexion.class.php';
        $ControleurConnexion = new ControleurConnexion();
        if ($ControleurConnexion->isConnected()) {

            $user = JWT::decode($_COOKIE['user'], VariablesGlobales::KEY);
            if ($user->isAdmin == true) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function afficherIndex() {
        if(self::isAdmin()){
        require_once chemins::VUES_ADMIN . 'v_index_admin.inc.php';
        }
        else{
            require_once chemins::VUES_ADMIN . 'v_acces_interdit.inc.php';
        }
    }

}
