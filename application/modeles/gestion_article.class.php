<?php

/**
 * Contient tous les services de gestion des articles
 */
class Gestionarticle extends GestionBDD {

    /**
     * Retourne la liste des catégorie
     * @return type Tableau d'objets
     */
    public static function getLesarticles() {

        return self::getLesTuples("article");
    }

    public static function getLesarticlesBycategorie($idcategorie) {

        return parent::getLesTuplesByChamp("article", "idcategorie", $idcategorie);
    }

    /**
     * Retourne un article grâce à son ID
     * @param type $idarticle
     * @return type Un objet article
     */
    public static function getarticleByID($idarticle) {
        self::seConnecter();
        parent::$request = "SELECT * FROM article WHERE idarticle= :idarticle";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
        self::$pdoStResults->bindValue('idarticle', $idarticle);
        self::$pdoStResults->execute();
        self::$result = self::$pdoStResults->fetch();

        self::$pdoStResults->closeCursor();

        return self::$result;
    }
    
    
      /**
     * Retourne le premier article
     * @return type Un objet article
     */
    public static function getFirstarticle() {
        self::seConnecter();
        parent::$request = "SELECT * FROM article order by idarticle limit 1";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
        self::$pdoStResults->execute();
        self::$result = self::$pdoStResults->fetch();

        self::$pdoStResults->closeCursor();
        return self::$result;
        
    }
    
    
    

    /**
     * Retourne le nombre de produits présent dans la base de données
     * @return type String
     */
    public static function getNbarticles() {
        self::seConnecter();
        self::$request = "SELECT Count(*) as nbarticles FROM article";

        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
        self::$pdoStResults->execute();
        self::$result = self::$pdoStResults->fetch();

        self::$pdoStResults->closeCursor();

        return self::$result->nbarticles;
    }

    /**
     * Ajoute un article à la BDD
     * @param type Nom de l'article
     * @param type date de création de l'article
     * @param type Contenu de l'article
     * @param type résumé de l'article
     * @param type miniature de l'article
     * @param type ID de la catégorie de l'article
     * @param type ID du créateur de l'article

     */
    public static function ajouterarticle($titre, $date, $contenu, $resume, $miniature, $idcategorie, $idcreateura) {
        $article = array(
            "idarticle" => self::genererClePrimaire("idarticle", "article"),
            "titre" => $titre,
            "datearticle" => $date,
            "contenuarticle" => $contenu,
            "resumearticle" => $resume,
            "miniature" => $miniature,
            "idcategorie" => $idcategorie,
            "idcreateura" => $idcreateura
        );
        parent::modifTable("insert", $article, "article");
    }

    /**
     * Modifie un produit de la BDD
     * @param type type ID de l'article
     * @param type titre de l'article
     * @param type date de création de l'article
     * @param type Contenu de l'article
     * @param type résumé de l'article
     * @param type miniature de l'article
     * @param type ID de la catégorie de l'article
     * @param type ID du créateur de l'article
     */
    public static function modifierarticle($id, $titre, $date, $contenu, $resume, $miniature, $idcategorie, $idutilisateur) {
        $article = array(
            "idarticle" => $id,
            "titre" => $titre,
            "datearticle" => $date,
            "contenuarticle" => $contenu,
            "resumearticle" => $resume,
            "miniature" => $miniature,
            "idcategorie" => $idcategorie,
            "idcreateura" => $idutilisateur
        );
        parent::modifTable("update", $article, "article");
    }

    /**
     * Supprime un article de la BDD
     * @param type ID de l'article
     */
    public static function deletearticle($idarticle) {
        parent::deleteTupleTableById("article", $idarticle);
    }

    // </editor-fold>
}

//Test des services (méthodes) de la classe ShopManagement
//-------------------------------------------------------
