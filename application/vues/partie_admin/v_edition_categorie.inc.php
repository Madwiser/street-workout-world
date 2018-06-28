<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <form id='form-crea-article' class="well"  action='admin/editionCategorie' method='post' >     
                     <span class="form-group">
                    <label for="id"  > </label>
                    <input type="hidden" name='id' value="<?php echo VariablesGlobales::$lacategorie->idcategorie ?>" class="form-control"> 
                </span>
                
                <span class="form-group">
                    <label for="libelle" > Libelle : </label>
                    <input type="text" name='libelle' value="<?php echo VariablesGlobales::$lacategorie->libellecategorie ?>" class="form-control"> 
                </span>

                <span class="form-group">
                    <input style="width: 100%;"  type='submit' value="Modifier la catégorie" class="form-control" id='btn-ajout-article'>
                </span>
            </form>
        </div>
    </div>
</div>