<section style='padding-bottom: 25px;'>
    <div class="titre">
        Administration du site (Accès réservé) <br />
        - Bonjour <?php echo JWT::decode($_COOKIE['user'], VariablesGlobales::KEY)->login; ?> -
    </div>
    
    <div class="cat1">
        <a href="admin/gestionArticles"><img src='<?php echo chemins::IMAGES . "martournal.png"; ?>' height="75" width="75">Gestion des articles </a><br />       
    </div>
    <div class='cat2'>       
        <a href="admin/gestionMuscles"><img src='<?php echo chemins::IMAGES . "muscles.jpg"; ?>'  height="75" width="75" > Gestion des muscles </a>
    </div>
     <div class='cat2'>       
        <a href="admin/gestionCategories"><img src='<?php echo chemins::IMAGES . "categorie.png"; ?>'  height="75" width="75" >Gestion des categories</a>
    </div>
</section>