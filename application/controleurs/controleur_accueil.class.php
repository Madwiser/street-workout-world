<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controleur_produits
 *
 * @author Luangpraseuth Alexis
 */
class ControleurAccueil {
    //put your code here
    public function __construct(){

    }

    public function afficherarticleAccueil(){
        VariablesGlobales::$unarticle = Gestionarticle::getFirstarticle();
        require_once chemins::VUES . 'v_accueil.inc.php';

    }

    public function afficherRecapNews() {
        VariablesGlobales::$lesNews = GestionNews::getLesNews();
        require chemins::VUES_ADMIN . "v_recap_news.inc.php";
    }

    public function ajouterNews() {
        GestionNews::ajouterNews($_POST['contenu'],$_POST['titre'], date("Y-m-d H:i:s"));
    }

    public function supprNews() {
        $i = 1;
        VariablesGlobales::$lesNews = GestionNews::getLesNews();


        foreach (VariablesGlobales::$lesNews as $uneNews) {


            if (isset($_POST['deletebox' . $i])){
                GestionNews::deleteNews($uneNews->idnews);
            }
            if(isset($_POST['btnSuppr' . $i])){
                GestionNews::deleteNews($uneNews->idnews);

            }
            $i = $i +1;
        }
    }


}
