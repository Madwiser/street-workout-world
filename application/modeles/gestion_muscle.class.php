<?php

class Gestionmuscle extends GestionBDD{


    /**
     * Retourne le muscle correspondant à l'id en paramètre
     * @return type objet exercice
     */
    public static function getmusclebyId($id) {
        return self::getleTupleTableById('muscle',$id);
    }

    /**
     * Retourne la liste des muscles
     * @return type Tableau d'objets
     */
    public static function getLesmuscles() {
        return self::getLesTuples('muscle');
        
    }

    /**
     * Ajoute un muscle à la BDD
     * @param type Nom du muscle
     * @param type id de la zone du muscle


     */
    public static function ajoutermuscle($nom,$zone) {
        $muscle = (object) array(
            "idexercice" => self::genererClePrimaire("idmuscle","muscle"),
            "nommuscle" => $nom,
            "idzone" => $zone

        );
        parent::modifTable("insert",$muscle, "muscle");
    }




    /**
    * Modifie un muscle de la BDD
    * @param type id du muscle
    * @param type Nom du muscle
    * @param type id de la zone du muscle

     */
    public static function modifiermuscle($id,$nom,$zone) {
        self :: seConnecter();
        try {
          $exercice = (object) array(
              "idexercice" => $id,
              "nommuscle" => $nom,
              "idzone" => $zone
          );
          parent::modifTable("update",$muscle, "muscle");
        } catch (Exception $ex) {
            echo 'Erreur : ' . $ex->getMessage();
        }
    }

    /**
     * Supprime un muscle de la BDD
     * @param type ID du muscle
     */
    public static function deletemuscle($idmuscle) {
      self::seConnecter();
      try {
          self::$request = "DELETE FROM muscletravaille WHERE idmuscle= :id";
          self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
          self::$pdoStResults->bindValue('id', $idmuscle);
          self::$pdoStResults->execute();

          parent::deleteTupleTableById("muscle",$idmuscle);
      } catch (Exception $ex) {
          echo 'Erreur : ' . $ex->getMessage();
      }

    }
}
