<?php

//Classe statique
// A placer dans dossier libs et à compléter au besoin

class Panier {

    public static function initialiser() {
        if (!isset($_SESSION['produits'])) {
            $_SESSION['produits'] = array();
        }
    }

    public static function ajouterProduit($leProduit) {
        $_SESSION['produits'][] = $leProduit;
    }

    public static function retirerProduit($idProduit) {
        $lesProduits = self::getProduits();
        $nouveauPanier = array();

        $i = 0;
        foreach ($lesProduits as $unProduit) {
            if ($unProduit->idProduit == $idProduit) {
                break;
            }
            $nouveauPanier[] = $unProduit;
            $i++;
        }
        
        $_SESSION['produits'] = array_merge($nouveauPanier, array_slice($lesProduits, $i+1));
    }

    public static function getProduits() {
        if (isset($_SESSION['produits'])) {
            return $_SESSION['produits'];
            //return array_column($_SESSION['produits'], 0);
        }
        return null;
    }

    public static function getNbProduits() {
        $nb = 0;
        if (isset($_SESSION['produits'])) {
            $nb = count($_SESSION['produits']);
        }
        return $nb;
        // ou en 1 ligne : 
        //return isset($_SESSION['produits'])?count($_SESSION['produits']):0;
    }

    public static function vider() {
        $_SESSION['produits'] = array();
    }

    public static function detruire() {
        unset($_SESSION['produits']);
    }

    public static function estVide() {
        return (self::nbProduits() == 0);
    }

    public static function contient($leProduit) {
//        $lesProduits = self::getProduits();
//
//        foreach ($lesProduits as $unProduit) {
//            if ($unProduit == $leProduit) {
//                return true;
//            }
//        }
//        return false;
        return in_array($leProduit, self::getProduits());
    }

}

?>
