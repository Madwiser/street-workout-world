<?php

require_once('vendor/autoload.php');
require_once 'configs/chemins.class.php';
require_once chemins::CONFIGS . 'variables_globales.class.php';
require_once chemins::CONFIGS . 'pgsql_config.class.php';
require_once chemins::MODELES . 'gestion_bdd.class.php';
require_once chemins::MODELES . 'gestion_article.class.php';
require_once chemins::MODELES . 'gestion_categorie_article.class.php';
require_once chemins::MODELES . 'gestion_entrainement.class.php';
require_once chemins::MODELES . 'gestion_exercice.class.php';
require_once chemins::MODELES . 'gestion_muscle.class.php';
require_once chemins::MODELES . 'gestion_utilisateur.class.php';
require_once chemins::LIBS . 'Panier.class.php';
require_once chemins::LIBS . 'jwt.class.php';



//var_dump($_SERVER['REQUEST_URI']);
$path = ltrim($_SERVER['REQUEST_URI'], '/');    // Trim leading slash(es)
//var_dump($path);
$elements = explode('/', $path);                // Split path on slashes
//var_dump($elements);
if (empty($elements[1]) || $elements[1] == 'index.php' || $elements[1] == 'home') {                       // No path elements means home
    $controleur = 'accueil';
    $action = 'afficherarticleAccueil';
} else {
    switch ($elements[1]) {
        case 'admin':

            if (empty($elements[2])) {
                $controleur = 'admin';
                $action = 'afficherIndex';
            } else {
                $controleurElements = explode('_', $elements[2]);
                $controleur = $controleurElements[1];
                if (empty($elements[3])) {
                    $action = 'gestion' . ucfirst($controleur);
                } else {
                    $actionElements = explode('_', $elements[3]);
                    $action = $actionElements[0] . ucfirst($actionElements[1]);
                    if (!empty($elements[4])) {
                        VariablesGlobales::$edit = $elements[4];
                    }
                }
            }

            break;

        case 'connexion':
            $controleur = "connexion";
            $action = "seConnecter";
            break;

        case 'deconnexion':
            $controleur = "connexion";
            $action = "seDeconnecter";
            break;

        case 'inscription':
            $controleur = "utilisateur";
            $action = "inscription";
            break;

        default :
            $controleur = 'accueil';
            $action = 'afficherarticleAccueil';
            break;
    }
}

require_once chemins::VUES_PERMANENTES . 'v_entete.inc.php';
//var_dump($controleur);
//var_dump($action);
//$controleur =           !isset($_REQUEST['controleur']) ? 'accueil' : $_REQUEST['controleur'];
$fichier_controleur = 'controleur_' . $controleur . '.class.php';
$classe_controleur = 'Controleur' . $controleur;
//$action =               !isset($_REQUEST['action']) ? 'afficherarticleAccueil' : $_REQUEST['action'];

require_once chemins::CONTROLEURS . $fichier_controleur;

$classe_controleur = new $classe_controleur();
$classe_controleur->$action();
ob_end_flush(); // Flush the output from the buffer

require_once chemins::VUES_PERMANENTES . 'v_pied.inc.php';
