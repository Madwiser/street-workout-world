<?php

class Gestionentrainement extends GestionBDD{

    /**
     * Retourne la liste des entrainements de l'utilisateur
     * @return type Tableau d'objets
     */
    public static function getLesentrainementsByUtil($id) {
        return self::getLesTuplesByChamp('entrainement',"");
    }

    /**
     * Retourne l'entraînement correspondant à l'id en paramètre
     * @return type objet entrainement
     */
    public static function getentrainementbyId($id) {
        return self::getleTupleTableById('entrainement',$id);
    }



    /**
     * Retourne la liste des entrainements validés par un administrateur
     * @return type Tableau d'objets
     */
    public static function getLesentrainementsValides() {
        return self::getLesTuplesByChamp('entrainement','verifentrainement','true');
    }

    /**
     * Retourne la liste des entrainements par niveau
     * @return type Tableau d'objets
     */
    public static function getLesentrainementsByLevel($idLevel) {
      try{
        self::seConnecter();
        self::$request = "SELECT * FROM entrainement where identrainement in(
        select identrainement from compositionentrainement C, exercice E,typeexercice T WHERE idDifficulte= :id and C.idexercice=E.idexercice and E.idtype=T.idtype) ";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
        self::$pdoStResults->bindValue('id', $idLevel);
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
     * Retourne la liste des entrainements par zoneDuCorps
     * @return type Tableau d'objets
     */
    public static function getLesentrainementsByzone($libellezone) {
      try{
        self::seConnecter();
        if($libellezone == "fullbody"){
        self::$request = "SELECT * FROM entrainement where identrainement in(select identrainement from compositionentrainement C, exercice E,muscle M,muscletravaille MT,zoneDuCorps Z where
        C.idexercice=E.idexercice and E.idexercice=MT.idexercice and MT.idmuscle = M.idmuscle and M.idzone=Z.idzone
        group by identrainement,libellezone having count(*)=3)";
      }elseif($libellezone == "lowerbody"){
        self::$request = "SELECT * FROM entrainement where identrainement in(select identrainement from compositionentrainement C, exercice E,muscle M,muscletravaille MT,zoneDuCorps Z where
        C.idexercice=E.idexercice and E.idexercice=MT.idexercice and MT.idmuscle = M.idmuscle and M.idzone=Z.idzone and Z.libellezone=lowerbody
        group by identrainement having count(*)>2)";
      }elseif($libellezone == "upperbody"){
        self::$request = "SELECT * FROM entrainement where identrainement in(select identrainement from compositionentrainement C, exercice E,muscle M,muscletravaille MT,zoneDuCorps Z where
        C.idexercice=E.idexercice and E.idexercice=MT.idexercice and MT.idmuscle = M.idmuscle and M.idzone=Z.idzone and Z.libellezone=upperbody
        group by identrainement having count(*)>2)";
      }
      else{
        self::$request = "SELECT * FROM entrainement where identrainement in(select identrainement from compositionentrainement C, exercice E,muscle M,muscletravaille MT,zoneDuCorps Z where
        C.idexercice=E.idexercice and E.idexercice=MT.idexercice and MT.idmuscle = M.idmuscle and M.idzone=Z.idzone and Z.libellezone=middlebody
        group by identrainement having count(*)>2)";
      }
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
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
     * Ajoute un entrainement à la BDD
     * @param type Contenu de l'entraînement
     * @param type durée de l'entraînement
     * @param type date de création de l'entraînement
     * @param type entrainement vérifié ou non
     * @param type ID du créateur de l'entraînement

     */
    public static function ajouterentrainement($contenu,$duree,$date, $verif,$idcreateure) {
        $entrainement = (object) array(
            "identrainement" => self::genererClePrimaire("identrainement","entrainement"),
            "contenuentrainement" => $contenu,
            "duree" => $duree,
            "dateentrainement" => $date,
            "verifentrainement" => $verif,
            "idcreateure" => $idcreateure
        );
        parent::modifTable("insert",$entrainement, "entrainement");
    }

    /**
     * Ajoute un exercice à l'entraînement dans la BDD
     * @param type id de l'entraînement
     * @param type id de l'exercice
     */
    public static function ajouterexerciceentrainement($identrainement,$idexercice) {
        $exoentrainement = (object) array(
            "identrainement" => $identrainement,
            "idexercice" => $idexercice
        );
        parent::modifTable("insert",$exoentrainement, "compositionentrainement");
    }

    /**
     * Supprime un exercice de l'entrainement de la BDD
     * @param type ID de l'article
     */
    public static function deleteexerciceentrainement($identrainement,$idExerice) {
      self::seConnecter();
      try {
          self::$request = "DELETE FROM compositionentrainement WHERE identrainement= :id and idexercice= :idE";
          self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
          self::$pdoStResults->bindValue('id', $identrainement);
          self::$pdoStResults->bindValue('idE', $idExerice);
          self::$pdoStResults->execute();
      } catch (Exception $ex) {
          echo 'Erreur : ' . $ex->getMessage();
      }

    }




    /**
    * Modifie un entrainement de la BDD
    * @param type Contenu de l'entraînement
    * @param type durée de l'entraînement
    * @param type date de création de l'entraînement
    * @param type entrainement vérifié ou non
    * @param type ID du créateur de l'entraînement
     */
    public static function modifierentrainement($id,$contenu,$duree,$date, $verif,$idcreateure) {
        self :: seConnecter();
        try {
            self::$request = "UPDATE entrainement SET  contenuentrainement=:contenuentrainement, duree= :duree, dateentrainement= :dateentrainement, verifentrainement= :verifentrainement,idcreateure= :idcreateure WHERE identrainement= :identrainement";
            self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
            self::$pdoStResults->bindValue('identrainement', $id);
            self::$pdoStResults->bindValue('contenuentrainement', $contenu);
            self::$pdoStResults->bindValue('duree', $duree);
            self::$pdoStResults->bindValue('dateentrainement', $date);
            self::$pdoStResults->bindValue('verifentrainement', $verif);
            self::$pdoStResults->bindValue('idcreateure', $idcreateure);
            self::$pdoStResults->execute();
        } catch (Exception $ex) {
            echo 'Erreur : ' . $ex->getMessage();
        }
    }

    /**
     * Supprime un entraînement de la BDD
     * @param type ID de l'entrainement
     */
    public static function deleteentrainement($identrainement) {
      self::seConnecter();
      try {
          self::$request = "DELETE FROM compositionentrainement WHERE identrainement= :id";
          self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
          self::$pdoStResults->bindValue('id', $identrainement);
          self::$pdoStResults->execute();

          parent::deleteTupleTableById("entrainement",$identrainement);
      } catch (Exception $ex) {
          echo 'Erreur : ' . $ex->getMessage();
      }

    }
}
