<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <form id='form-crea-article' class="well"  action='admin/gestionArticles/ajouterArticle' method='post' enctype="multipart/form-data" >     

                <span class="form-group">
                    <label for="titre"> Titre : </label>
                    <input type="text" name='titre' class="form-control"> 
                </span>
                <span class="form-group">
                    <label for="contenu">Contenu :</label>
                    <textarea name='contenu' placeholder="Entrer le contenu de l'article" class="form-control" rows="12" ></textarea>   
                </span>
                <span class="form-group">
                    <label for="résumé">Résumé :</label>
                    <textarea name='resume' placeholder="Entrer le résumé de l'article" class="form-control" rows="12" ></textarea>   
                </span>
                  <span class="form-group">
                    <label for="miniature">Miniature(lien de l'image) :</label>
                    <input type="text" name='miniature' placeholder="Entrer la miniature de l'article" class="form-control" /> 
                </span>

                <span class="form-group">
                    Catégorie:
                    <?php
                foreach (VariablesGlobales::$lescategories as $unecategorie) {
                    ?>
                    <input type="radio" name="categorie" value="<?php echo $unecategorie->idcategorie ?>"  />  <label><?php echo $unecategorie->libellecategorie ?></label>
                </span>
                <?php } ?>
                  <span class="form-group">
                    <input type="hidden" name='idcreateur' value=" <?php echo JWT::decode($_COOKIE['user'], VariablesGlobales::KEY)->idUser; ?>" class="form-control"> 
                </span>
                
                <span class="form-group">
                    <input style="width: 100%;"  type='submit' value="Ajouter l'article" class="form-control" id='btn-ajout-article'>
                </span>
            </form>
        </div>
    </div>
</div>
