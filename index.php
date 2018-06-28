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


    
var_dump($_SERVER['REQUEST_URI']);
$path = ltrim($_SERVER['REQUEST_URI'], '/');    // Trim leading slash(es)
var_dump($path);
$elements = explode('/', $path);                // Split path on slashes
var_dump($elements);
if( empty($elements[1]) || $elements[1] == 'index.php' || $elements[1] == 'home') {                       // No path elements means home
    $controleur = 'accueil';
    $action = 'afficherarticleAccueil';
} else{ switch($elements[1]){            // Pop off first item and switch
case 'admin':
    $controleur = $elements[0];
    $action = $elements[1];
    break;
        
case '':
    $controleur = $elements[0];
    $action = $elements[1];
    break;

default :
     header('HTTP/1.1 404 Not Found');
     break;
}
}

require_once chemins::VUES_PERMANENTES . 'v_entete.inc.php';

//$controleur =           !isset($_REQUEST['controleur']) ? 'accueil' : $_REQUEST['controleur'];
$fichier_controleur =   'controleur_'.$controleur.'.class.php';
$classe_controleur =    'Controleur'.$controleur;
//$action =               !isset($_REQUEST['action']) ? 'afficherarticleAccueil' : $_REQUEST['action'];

require_once chemins::CONTROLEURS . $fichier_controleur;

$classe_controleur = new $classe_controleur();
$classe_controleur->$action();
 ob_end_flush(); // Flush the output from the buffer

require_once chemins::VUES_PERMANENTES . 'v_pied.inc.php';
