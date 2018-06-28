<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <form id='form-crea-article' class="well"  action='editionArticle' method='post' enctype="multipart/form-data" >     

                <span class="form-group">
                    <label for="id"  ></label>
                    <input type="hidden" name='id' value="<?php echo VariablesGlobales::$unarticle->idarticle ?>" class="form-control"> 
                </span>

                <span class="form-group">
                    <label for="titre"> Titre : </label>
                    <input type="text" name='titre' value='<?php echo VariablesGlobales::$unarticle->titre ?>' class="form-control"> 
                </span>
                <span class="form-group">
                    <label for="contenu">Contenu :</label>
                    <textarea name='contenu'  placeholder="Entrer le contenu de l\'article" class="form-control" rows="12" ><?php echo VariablesGlobales::$unarticle->contenuarticle ?></textarea>   
                </span>
                <span class="form-group">
                    <label for="résumé">Résumé :</label>
                    <textarea name='resume' placeholder="Entrer le résumé de l\'article" class="form-control" rows="12" ><?php echo VariablesGlobales::$unarticle->resumearticle ?></textarea>   
                </span>
                  <span class="form-group">
                    <label for="miniature">Miniature(lien de l'image) :</label>
                    <input type="text" value="<?php echo VariablesGlobales::$unarticle->miniature ?>" name='miniature' placeholder="Entrer la miniature de l\'article" class="form-control" /> 
                </span>

                <span class="form-group">
                    Catégorie:
                    <?php
                foreach (VariablesGlobales::$lescategories as $unecategorie) {
                    $check ="";
                    if($unecategorie->idcategorie == VariablesGlobales::$unarticle->idcategorie)
                    {
                        $check = "checked";
                    }
                    ?>
                    <input type="radio" name="categorie" <?php echo $check ?> value="<?php echo $unecategorie->idcategorie ?>"  />  <label><?php echo $unecategorie->libellecategorie ?></label>
                </span>
                <?php } ?>
                  <span class="form-group">
                    <label for="idcreateur"  > </label>
                    <input type="hidden" name='idcreateur' value=" <?php echo JWT::decode($_COOKIE['user'], VariablesGlobales::KEY)->idUser; ?>" class="form-control"> 
                </span>
                
                <span class="form-group">
                    <input style="width: 100%;"  type='submit' value="Editer l'article" class="form-control" id='btn-ajout-article'>
                </span>
            </form>
        </div>
    </div>
</div>