<section>
    <div id="article_autre">
        <div class="container">
            <?php if (isset($_COOKIE['user']) && JWT::decode($_COOKIE['user'], VariablesGlobales::KEY)->isAdmin == true) { ?>
                <div class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-primary" href="admin/gestionCategories/creationCategorie" id="btn-ajout-news" >Ajouter une catégorie</a>
                    </div>
                </div>        


                <?php
                $i = 1;
                foreach (VariablesGlobales::$lescategories as $unecategorie) {
                    ?>
                    <div class="row" style="border-top: 1px solid #c0c0c0; margin-top: 8px;">
                        <div class="col-lg-2">
                                <div class="row">
                                    <aside class="col-lg-12" style="margin-top: 25px;">
                                        <form action="admin/gestionCategories/supprimerCategorie" method="post">
                                            <input name="btnSuppr<?php echo $i ?>" class="btn btn-danger" type="submit" value="Supprimer la catégorie">
                                        </form>
                                        <form action="admin/gestionCategories/creationCategorie/<?php echo $unecategorie->idcategorie ?>" method="post">
                                            <input name="btnEdit" class="btn btn-danger" type="submit" value="Editer la catégorie">
                                        </form>
                                    </aside>
                                </div>
                                <?php $i = $i + 1;
                             ?>
                        </div>

                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-12">     
                                    <h1 style="color: #0066FF;"> <?php echo $unecategorie->libellecategorie ?> </h1>
                                </div>              
                            </div>
                        </div>
                    </div>
                    <?php }
            }
            ?>
        </div>
    </div>                                               
</section>
