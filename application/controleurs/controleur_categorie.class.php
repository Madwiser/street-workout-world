<?php

class Controleurcategorie {

    public function afficherCategories() {
        VariablesGlobales::$lescategories = Gestioncategoriearticle::getLescategoriearticle();
        require chemins::VUES_ADMIN . "v_categories.inc.php";
    }
    
    public function editercategorie(){
         require_once chemins::CONTROLEURS . 'controleur_admin.class.php';
        $ControleurAdmin = new ControleurAdmin();
        if ($ControleurAdmin->isAdmin()) {
            //var_dump($_REQUEST['edit']);
            if(isset($_REQUEST['edit']) && !empty($_REQUEST['edit'])){
                $idCategorie = htmlspecialchars($_REQUEST['edit']);
                VariablesGlobales::$lacategorie = Gestioncategoriearticle::getLacategoriearticleById($idCategorie);
                //var_dump(VariablesGlobales::$lacategorie);
                 require_once chemins::VUES_ADMIN . "v_edition_categorie.inc.php";
            }
            else{
                require_once chemins::VUES_ADMIN . 'v_acces_interdit.inc.php';
            }
        } else {
            require_once chemins::VUES_ADMIN . 'v_acces_interdit.inc.php';
        }
    }
    
    public function updatecategorie(){
         if (isset($_POST['libelle']) && !empty($_POST['libelle'])) {
       
            Gestioncategoriearticle::modifiercategoriearticle(htmlspecialchars($_POST['id']),htmlspecialchars($_POST['libelle']));
            self::afficherCategories();
        }
    }

    public function nouvellecategorie() {
        require_once chemins::CONTROLEURS . 'controleur_admin.class.php';
        $ControleurAdmin = new ControleurAdmin();
        if ($ControleurAdmin->isAdmin()) {
            require_once chemins::VUES_ADMIN . "v_creationCategorie.inc.php";
        } else {
            require_once chemins::VUES_ADMIN . 'v_acces_interdit.inc.php';
        }
    }

    public function ajoutercategorie() {
        if (isset($_POST['libelle'])) {
            Gestioncategoriearticle::ajoutercategoriearticle(htmlspecialchars($_POST['libelle']));
            self::afficherCategories();
        }
    }

    public function supprimercategorie() {
        $i = 1;
        VariablesGlobales::$lescategories = Gestioncategoriearticle::getLescategoriearticle();


        foreach (VariablesGlobales::$lescategories as $uneCategorie) {


            if (isset($_POST['btnSuppr' . $i])) {
                Gestioncategoriearticle::deletecategoriearticle($uneCategorie->idcategorie);
            }

            $i = $i + 1;
        }

        self::afficherCategories();
    }

}
