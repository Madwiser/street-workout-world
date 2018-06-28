<?php

class Gestionexercice extends GestionBDD{

    /**
     * Retourne la liste des exercices du type en paramètre
     * @return type Tableau d'objets
     */
    public static function getLesexercicesByType($idType) {
        return self::getLesTuplesByChamp('entrainement',"idType",$idType);
    }

    /**
     * Retourne la liste des exercices du niveau en paramètre
     * @return type Tableau d'objets
     */
    public static function getLesexercicesByLevel($idLevel) {
        return self::getLesTuplesByChamp('entrainement',"idDifficulte",$idLevel);
    }

    /**
     * Retourne l'exercice correspondant à l'id en paramètre
     * @return type objet exercice
     */
    public static function getexercicebyId($id) {
        return self::getleTupleTableById('exercice',$id);
    }

    /**
     * Retourne la liste des exercices
     * @return type Tableau d'objets
     */
    public static function getLesexercices() {
        return self::getLesTuples('exercice');
        
    }

    /**
     * Retourne la liste des exercices par muscle
     * @return type Tableau d'objets
     */
    public static function getLesexercicesBymuscle($idmuscle) {
      try{
        self::seConnecter();
        self::$request = "SELECT * FROM exercice where idexercice in(
        select M.idexercice from muscletravaille M WHERE M.idmuscle= :id) ";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
        self::$pdoStResults->bindValue('id', $idmuscle);
        self::$pdoStResults->execute();
        self::$result = self::$pdoStResults->fetchAll();
        self::$pdoStResults->closeCursor();

        return self::$result;
      } catch (Exception $ex) {
          echo 'Erreur : ' . $ex->getMessage() . '<br />';
          echo 'Code : ' . $ex->getCode();
      }
    }


    /**
     * Ajoute un muscle à l'exercice dans la BDD
     * @param type id de l'entraînement
     * @param type id de l'exercice
     */
    public static function ajoutermuscleexercice($idexercice,$idmuscle) {
        $muscleexercice = (object) array(
            "idexercice" => $idexercice,
            "idmuscle" => $idmuscle
        );
        parent::modifTable("insert",$muscleexercice, "muscletravaille");
    }





    /**
     * Supprime un muscle de l'exercice de la BDD
     * @param type ID de l'article
     */
    public static function deletemuscleexercice($idexercice,$idmuscle) {
      self::seConnecter();
      try {
          self::$request = "DELETE FROM muscletravaille WHERE idexercice= :id and idmuscle= :idE";
          self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
          self::$pdoStResults->bindValue('id', $idexercice);
          self::$pdoStResults->bindValue('idM', $idmuscle);
          self::$pdoStResults->execute();
      } catch (Exception $ex) {
          echo 'Erreur : ' . $ex->getMessage();
      }

    }


    /**
     * Ajoute un exercice à la BDD
     * @param type Nom de l'exercice
     * @param type Contenu de l'exercice
     * @param type difficulté de l'exercice
     * @param type type d'exercice

     */
    public static function ajouterexercice($nom,$contenu,$difficulte, $type) {
        $exercice = (object) array(
            "idexercice" => self::genererClePrimaire("idexercice","exercice"),
            "nomexercice" => $nom,
            "contenuexercice" => $contenu,
            "idDifficulte" => $difficulte,
            "idType" => $type
        );
        parent::insertInTable($exercice, "exercice");
    }




    /**
    * Modifie un exercice de la BDD
    * @param type id de l'exercice
    * @param type Nom de l'exercice
    * @param type Contenu de l'exercice
    * @param type difficulté de l'exercice
    * @param type type d'exercice
     */
    public static function modifierentrainement($id,$contenu,$duree,$date, $verif,$idcreateure) {
        self :: seConnecter();
        try {
          $exercice = (object) array(
              "idexercice" => $id,
              "nomexercice" => $nom,
              "contenuexercice" => $contenu,
              "idDifficulte" => $difficulte,
              "idType" => $type
          );
          parent::modifTable("update",$exercice, "exercice");
        } catch (Exception $ex) {
            echo 'Erreur : ' . $ex->getMessage();
        }
    }

    /**
     * Supprime un exercice de la BDD
     * @param type ID de l'exercice
     */
    public static function deleteexercice($idexercice) {
      self::seConnecter();
      try {
          self::$request = "DELETE FROM muscletravaille WHERE idexercice= :id";
          self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
          self::$pdoStResults->bindValue('id', $idexercice);
          self::$pdoStResults->execute();

          parent::deleteTupleTableById("exercice",$idexercice);
      } catch (Exception $ex) {
          echo 'Erreur : ' . $ex->getMessage();
      }

    }
}
