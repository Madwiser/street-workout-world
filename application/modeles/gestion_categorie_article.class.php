<?php

class Gestioncategoriearticle extends GestionBDD {

    public static function getLescategoriearticle() {
        return self::getLesTuples("categoriearticle");
    }

    public static function getLacategoriearticleById($idCategorie) {
        self::seConnecter();
        try {


            self::$request = "SELECT * FROM categoriearticle WHERE idcategorie= :id";
            self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
            self::$pdoStResults->bindValue('id', $idCategorie);
            self::$pdoStResults->execute();
            self::$result = self::$pdoStResults->fetch();
            self::$pdoStResults->closeCursor();
            return self::$result;
        } catch (Exception $ex) {
            echo 'Erreur : ' . $ex->getMessage();
        }
    }

    /**
     * Ajoute une catégoriearticle à la BDD
     * @param type Libelle de la catégorie
     */
    public static function ajoutercategoriearticle($libelleCateg) {
        $categorie = ["idcategorie" => self::genererClePrimaire("idcategorie", "categoriearticle"),
            "libellecategorie" => $libelleCateg
        ];
        parent::modifTable("insert", $categorie, "categoriearticle");
    }

    /**
     * Supprime une catégoriearticle de la BDD
     * @param type ID de la catégorie
     */
    public static function deletecategoriearticle($id) {
        self::seConnecter();
        try {
            self::$request = "DELETE FROM article WHERE idcategorie= :id";
            self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
            self::$pdoStResults->bindValue('id', $id);
            self::$pdoStResults->execute();

            self::$request = "DELETE FROM categoriearticle WHERE idcategorie= :id";
            self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
            self::$pdoStResults->bindValue('id', $id);
            self::$pdoStResults->execute();
        } catch (Exception $ex) {
            echo 'Erreur : ' . $ex->getMessage();
        }
    }

    /**
     * Modifie une catégoriearticle de la BDD
     * @param type ID de la catégorie
     * @param type libelle de la catégorie
     */
    public static function modifiercategoriearticle($idcategorie, $libelleCateg) {
        self :: seConnecter();
        try {
            self::$request = "UPDATE categoriearticle SET libellecategorie= :libelleCateg WHERE idcategorie= :idCateg";
            self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
            self::$pdoStResults->bindValue('idCateg', $idcategorie);
            self::$pdoStResults->bindValue('libelleCateg', $libelleCateg);
            self::$pdoStResults->execute();
        } catch (Exception $ex) {
            echo 'Erreur : ' . $ex->getMessage();
        }
    }

}
