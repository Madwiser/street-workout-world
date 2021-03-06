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
    public function __construct() {
        
    }

    public function afficherArticles() {

        VariablesGlobales::$lesarticles = GestionArticle::getLesarticles();
        require_once chemins::VUES . 'v_articles.inc.php';
    }

    public function afficherArticlesCategorie() {
        if (!empty(VariablesGlobales::$libelleCategorie)) {
            $idcategorie = Gestioncategoriearticle::getidCategoriearticleByLibelle(VariablesGlobales::$libelleCategorie);
            if (!empty($idcategorie)) {
                VariablesGlobales::$lesarticles = GestionArticle::getLesarticlesBycategorie($idcategorie);
                require_once chemins::VUES . 'v_articles.inc.php';
            }
            else{
                die("aucune categorie ne correspond...");
            }
        }
    }

    public function afficherArticle() {
        if (!empty(VariablesGlobales::$id)) {
            VariablesGlobales::$unarticle = GestionArticle::getarticleByID(VariablesGlobales::$id);
            if (!empty(VariablesGlobales::$unarticle)) {
                require_once chemins::VUES . 'v_article.inc.php';
            } else {
                die("aucun article ne correspond...");
            }
        }
    }

    public function gestionArticle() {
        VariablesGlobales::$lesarticles = GestionArticle::getLesarticles();
        require chemins::VUES_ADMIN . "v_gestion_articles.inc.php";
    }

    public function ajouterArticle() {
        if (isset($_POST['titre']) && !empty($_POST['titre']) && isset($_POST['contenu']) && !empty($_POST['contenu']) && isset($_POST['resume']) && !empty($_POST['resume']) && isset($_POST['miniature']) && !empty($_POST['miniature'])) {

            Gestionarticle::ajouterarticle(htmlspecialchars($_POST['titre']), date("Y-m-d"), htmlspecialchars($_POST['contenu']), htmlspecialchars($_POST['resume']), htmlspecialchars($_POST['miniature']), $_POST['categorie'], $_POST['idcreateur']);
            self::afficherRecapArticles();
        }
    }

    public function creationArticle() {
        require_once chemins::CONTROLEURS . 'controleur_admin.class.php';
        $ControleurAdmin = new ControleurAdmin();
        if ($ControleurAdmin->isAdmin()) {
            VariablesGlobales::$lescategories = Gestioncategoriearticle::getLescategoriearticle();
            require_once chemins::VUES_ADMIN . "v_creationArticle.inc.php";
        } else {
            require_once chemins::VUES_ADMIN . 'v_acces_interdit.inc.php';
        }
    }

    public function updateArticle() {
        if (isset($_POST['titre']) && !empty($_POST['titre']) && isset($_POST['contenu']) && !empty($_POST['contenu']) && isset($_POST['resume']) && !empty($_POST['resume']) && isset($_POST['miniature']) && !empty($_POST['miniature'])) {
            Gestionarticle::modifierarticle(htmlspecialchars($_POST['id']), htmlspecialchars($_POST['titre']), date("Y-m-d"), htmlspecialchars($_POST['contenu']), htmlspecialchars($_POST['resume']), htmlspecialchars($_POST['miniature']), $_POST['categorie'], $_POST['idcreateur']);
            self::afficherRecapArticles();
        }
    }

    public function modifierArticle() {
        require_once chemins::CONTROLEURS . 'controleur_admin.class.php';
        $ControleurAdmin = new ControleurAdmin();
        if ($ControleurAdmin->isAdmin()) {
            if (!empty(VariablesGlobales::$edit)) {
                $idArticle = htmlspecialchars(VariablesGlobales::$edit);
                VariablesGlobales::$unarticle = Gestionarticle::getarticleByID($idArticle);
                if (!empty(VariablesGlobales::$unarticle)) {
                    VariablesGlobales::$lescategories = Gestioncategoriearticle::getLescategoriearticle();
                    require_once chemins::VUES_ADMIN . "v_edition_article.inc.php";
                } else {
                    die("aucun article ne correspond...");
                }
            }
        } else {
            require_once chemins::VUES_ADMIN . 'v_acces_interdit.inc.php';
        }
    }

    public function supprimerArticle() {
        $i = 1;
        VariablesGlobales::$lesarticles = GestionArticle::getLesarticles();


        foreach (VariablesGlobales::$lesarticles as $unArticle) {

            if (isset($_POST['btnSuppr' . $i])) {
                GestionArticle::deleteArticle($unArticle->idarticle);
            }
            $i = $i + 1;
        }
        self::afficherRecapArticles();
    }

}
