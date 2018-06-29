<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gestion_bdd
 *
 * @author Luangpraseuth Alexis
 */
class GestionBDD {
    // <editor-fold defaultstate="collapsed" desc="Champs statiques">

    /**
     * Objet de la classe PDO
     * @var PDo
     */
    protected static $pdoCnxBase = null;

    /**
     * Objet de la classe PDOStatement
     * @var PDOStatement
     */
    protected static $pdoStResults = null;
    protected static $request = ""; //texte de la requête
    protected static $result = null; //resultat de la requête

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Méthodes statiques">
    /**
     * Se connecte à la base précisé dans la classe mysql_config
     */

    public static function seConnecter() {
        if (!isset(self::$pdoCnxBase)) {
            try {
                $db = parse_url(getenv("DATABASE_URL"));

self::$pdoCnxBase = new PDO("pgsql:" . sprintf(
    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $db["host"],
    $db["port"],
    $db["user"],
    $db["pass"],
    $db["name"]
));
                //self::$pdoCnxBase = new PDO('pgsql:host=' . PgSqlConfig::NOM_SERVEUR . ';port=' . PgSqlConfig::PORT . ';dbname=' . PgSqlConfig::NOM_BASE . ';user=' . PgSqlConfig::NOM_utilisateur . ';password=' . PgSqlConfig::MOT_DE_PASSE);
                self::$pdoCnxBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdoCnxBase->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                //self::$pdoCnxBase->query("SET CHARACTER SET utf8");
            } catch (Exception $e) {
                // l'objet pdoCnxBase a généré automatiquement un objet de type Exception
                echo 'Erreur : ' . $e->getMessage() . '<br />'; // Méthode de la classe Exception
                echo 'Code : ' . $e->getCode(); // Méthode de la classe exception
            }
        }
    }

    /**
     *  Se déconnecte de la base en cours
     */
    public static function seDeconnecter() {
        self::$pdoCnxBase = null;
        //si on appelle pas la méthode, la déconnexion a lieu en fin de script
    }

    /**
     * Retourne tout les tuples d'une table
     * @param string Table à parcourir
     * @return type
     */
    public static function getLesTuples($table) {
        try {
            self::seConnecter();
            self::$request = "SELECT * FROM $table";
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

    public static function genererClePrimaire($champ, $table) {
        self::seConnecter();
        self::$request = "SELECT max($champ)+1 as cle FROM $table";
        //var_dump(self::$request);
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
        self::$pdoStResults->execute();
        self::$result = self::$pdoStResults->fetch();
        //var_dump(self::$result->cle);
        self::$pdoStResults->closeCursor();
        if (self::$result->cle == NULL) {
            return 1;
        } else {
            return self::$result->cle;
        }
    }

    /**
     * Supprime une ligne de la table selon l'id
     * @param type $table nom de la table
     * @param type $id  id du tuple
     */
    public static function deleteTupleTableById($table, $id) {
        self::seConnecter();
        try {
            self::$request = "DELETE FROM " . $table . " where id" . $table . " = " . $id;
            self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
            self::$pdoStResults->execute();
        } catch (Exception $ex) {
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'Code : ' . $ex->getCode();
        }
    }

    /**
     * Retourne un tuple correspondant à l'id et à la table en paramètre
     * @param type $table table du tuple
     * @param type $id id du tuple
     * @return type objet
     */
    public static function getleTupleTableById($table, $id) {
        self::seConnecter();
        try {
            self::$request = "SELECT * FROM " . $table . " where id" . $table . " = " . $id;
            self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
            self::$pdoStResults->execute();
            self::$result = self::$pdoStResults->fetch();
            self::$pdoStResults->closeCursor();
            return self::$result;
        } catch (Exception $ex) {
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'Code : ' . $ex->getCode();
        }
    }

    /**
     * Retourne tout les tuples d'une liaison de deux tables
     * @param string $tableAParcourir
     * @param string $tableLiaison
     * @return type
     */
    public static function getLesTuplesSimpleJointure($tableAParcourir, $tableLiaison) {
        self::seConnecter();
        self::$request = "SELECT * FROM $tableSource NATURAL JOIN $tableLiaison";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
        self::$pdoStResults->execute();
        self::$result = self::$pdoStResults->fetchAll();

        self::$pdoStResults->closeCursor();

        return self::$result;
    }

    public static function getNbFrom($table) {
        self::seConnecter();
        try {
            self::$request = "SELECT count(*) as Nb FROM " . $table;
            self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
            self::$pdoStResults->execute();
            self::$result = self::$pdoStResults->fetch();
            self::$pdoStResults->closeCursor();
            return self::$result->Nb;
        } catch (Exception $ex) {
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'Code : ' . $ex->getCode();
        }
    }

    public static function getLeTupleByChamp($table, $champ, $val_champ) {
        self::seConnecter();

        $filtre = "";
        if (is_array($champ) && is_array($val_champ)) {
            for ($i = 0; $i < count($champ); $i++) {
                if ($i != count($champ) - 1) {
                    //var_dump($champ[$i]);
                    //var_dump($val_champ[$i]);
                    $filtre .= $champ[$i] . '=\'' . $val_champ[$i] . '\' and ';
                } else {
                    $filtre .= $champ[$i] . '=\'' . $val_champ[$i] . '\'';
                }
            }
            self::$request = "SELECT * FROM $table WHERE " . $filtre;
        } else {
            self::$request = "SELECT * FROM $table WHERE $champ = $val_champ";
        }

        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
        self::$pdoStResults->execute();
        self::$result = self::$pdoStResults->fetch();

        self::$pdoStResults->closeCursor();

        return self::$result;
    }
    
    public static function sql_escape_string($string) {
    return str_replace('\'', '\'\'', $string);
    
}
  public static function sql_unescape_string($string) {
    return str_replace( '\'\'','\'', $string);
    
}

    public static function getLesTuplesByChamp($table, $champ, $val_champ) {
        self::seConnecter();

        $filtre = "";
        if (is_array($champ) && is_array($val_champ)) {
            for ($i = 0; $i < count($champ); $i++) {
                if ($i != count($champ) - 1) {
                    $filtre .= $champ[$i] . '="' . $val_champ[$i] . '" and ';
                } else {
                    $filtre .= $champ[$i] . '="' . $val_champ[$i] . '"';
                }
            }
            self::$request = "SELECT * FROM $table WHERE " . $filtre;
        } else {
            self::$request = "SELECT * FROM $table WHERE $champ = $val_champ";
        }

        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
        self::$pdoStResults->execute();
        self::$result = self::$pdoStResults->fetchAll();

        self::$pdoStResults->closeCursor();

        return self::$result;
    }

    protected static function modifTable($type, $objet, $table) {
        try {
            self::seConnecter();
            self::$request = sprintf('select column_name, data_type, character_maximum_length from INFORMATION_SCHEMA.COLUMNS where table_name = \'' . $table . '\'');
            var_dump(self::$request);
            self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
            self::$pdoStResults->execute();
            $data = array();
            //var_dump(self::$pdoStResults->fetchAll(PDO::FETCH_ASSOC));
            foreach (self::$pdoStResults->fetchAll(PDO::FETCH_ASSOC) as $rows) {
                $data[] = $rows;
            }
            $valeurs = "";

            switch ($type) {
                case "insert":

                    //var_dump($data);
                    foreach ($data as $key => $att) {
                        //var_dump($key);
                        //var_dump($att['column_name']);
                        $field = $att['column_name'];
                        if (strncmp($att['data_type'], 'int', 3) == 0) {
                            if ($valeurs != "") {
                                $valeurs = $valeurs . "," . self::sql_escape_string($objet[(string) $field]);
                            } else {
                                $valeurs = $valeurs . self::sql_escape_string($objet[(string) $field]);
                            }
                        } else {
                            if ($valeurs != "") {
                                $valeurs = $valeurs . "," . "'" . self::sql_escape_string($objet[(string) $field]) . "'";
                            } else {
                                $valeurs = $valeurs . "'" . self::sql_escape_string($objet[(string) $field]) . "'";
                            }
                        }
                    }
                    self::$request = "insert into " . $table . " values(" . $valeurs . ")";
                    var_dump(self::$request);
                    self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
                    self::$pdoStResults->execute();
                    break;
                case "update":
                    //var_dump($data);
                    foreach ($data as $key => $att) {
                        //var_dump($key);
                        //var_dump($att['column_name']);
                        $field = $att['column_name'];
                        if ($key == 0)
                            $whereValue = $att['column_name'] . "=" . $objet[(string) $field];
                        if (strncmp($att['data_type'], 'int', 3) == 0) {
                            if ($valeurs != "")
                                $valeurs = $valeurs . "," . $att['column_name'] . "=" . self::sql_escape_string($objet[(string) $field]);
                            else
                                $valeurs = $valeurs . $att['column_name'] . "=" . self::sql_escape_string($objet[(string) $field]);
                        }
                        else {
                            if ($valeurs != "")
                                $valeurs = $valeurs . "," . $att['column_name'] . "=" . "'" . self::sql_escape_string($objet[(string) $field]) . "'";
                            else
                                $valeurs = $valeurs . $att['column_name'] . "=" . "'" . self::sql_escape_string($objet[(string) $field]) . "'";
                        }
                    }
                    self::$request = "update " . $table . " set " . $valeurs . " where " . $whereValue;
                    //var_dump(self::$request);
                    self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
                    self::$pdoStResults->execute();
                    break;
            }
        } catch (Exception $ex) {
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'Code : ' . $ex->getCode();
        }
    }

    public static function deleteFromTable($table, $filtre) {
        try {
            self::seConnecter();
            self::$request = "DELETE FROM $table WHERE $filtre";
            self::$pdoStResults = self::$pdoCnxBase->prepare(self::$request);
            self::$pdoStResults->execute();
        } catch (Exception $exc) {
            echo 'Erreur : ' . $exc->getMessage();
        }
    }

    // </editor-fold>
}
