<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controleur_article
 *
 * @author Luangpraseuth Alexis
 */
class ControleurArticle {
    //put your code here
    public function __construct(){

    }

    public function afficherLesArticles(){
        //VariablesGlobales::$lesProduits = gestion_boutique::getLesProduitsBycategorie($categorie);
        //require_once chemins::VUES . 'v_produit.inc.php' ;
        VariablesGlobales::$lesarticles = GestionArticle::getLesarticles();
        require_once chemins::VUES . 'v_accueil.inc.php';

    }

    public function afficherRecapArticles() {
        VariablesGlobales::$lesarticles = GestionArticle::getLesarticles();
        require chemins::VUES_ADMIN . "v_recap_articles.inc.php";
    }

    public function ajouterArticle() {
          if (isset($_POST['titre']) && !empty($_POST['titre']) && isset($_POST['contenu']) && !empty($_POST['contenu']) && isset($_POST['resume']) && !empty($_POST['resume']) && isset($_POST['miniature']) && !empty($_POST['miniature'])) {

            Gestionarticle::ajouterarticle(htmlspecialchars($_POST['titre']),date("Y-m-d"),htmlspecialchars($_POST['contenu']),htmlspecialchars($_POST['resume']),htmlspecialchars($_POST['miniature']),$_POST['categorie'],$_POST['idcreateur']);
            self::afficherRecapArticles();
        }
    }

    public function ecrireArticle() {
       require_once chemins::CONTROLEURS . 'controleur_admin.class.php';
        $ControleurAdmin = new ControleurAdmin();
        if ($ControleurAdmin->isAdmin()) {
                VariablesGlobales::$lescategories = Gestioncategoriearticle::getLescategoriearticle();
                 require_once chemins::VUES_ADMIN . "v_creationArticle.inc.php";
            }
            else{
                require_once chemins::VUES_ADMIN . 'v_acces_interdit.inc.php';
            }
    
    }
    
    public function updatearticle(){
         if (isset($_POST['titre']) && !empty($_POST['titre']) && isset($_POST['contenu']) && !empty($_POST['contenu']) && isset($_POST['resume']) && !empty($_POST['resume']) && isset($_POST['miniature']) && !empty($_POST['miniature'])) {
             Gestionarticle::modifierarticle(htmlspecialchars($_POST['id']),htmlspecialchars($_POST['titre']),date("Y-m-d"),htmlspecialchars($_POST['contenu']),htmlspecialchars($_POST['resume']),htmlspecialchars($_POST['miniature']),$_POST['categorie'],$_POST['idcreateur']);
            self::afficherRecapArticles();
        }
    }
    
     public function editerarticle(){
         require_once chemins::CONTROLEURS . 'controleur_admin.class.php';
        $ControleurAdmin = new ControleurAdmin();
        if ($ControleurAdmin->isAdmin()) {
            if(isset($_REQUEST['edit']) && !empty($_REQUEST['edit'])){
                $idArticle = htmlspecialchars($_REQUEST['edit']);
                VariablesGlobales::$unarticle = Gestionarticle::getarticleByID($idArticle);
                VariablesGlobales::$lescategories = Gestioncategoriearticle::getLescategoriearticle();
                 require_once chemins::VUES_ADMIN . "v_edition_article.inc.php";
            }
            else{
                require_once chemins::VUES_ADMIN . 'v_acces_interdit.inc.php';
            }
        } else {
            require_once chemins::VUES_ADMIN . 'v_acces_interdit.inc.php';
        }
    }

    public function supprArticle() {
        $i = 1;
        VariablesGlobales::$lesarticles = GestionArticle::getLesarticles();


        foreach (VariablesGlobales::$lesarticles as $unArticle) {

            if(isset($_POST['btnSuppr' . $i])){
                GestionArticle::deleteArticle($unArticle->idarticle);

            }
            $i = $i +1;
        }
        self::afficherRecapArticles();

    }

}
