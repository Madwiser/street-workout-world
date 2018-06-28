<section>
    <div id="article_autre">
        <div class="container">
            <?php if (isset($_COOKIE['user']) && JWT::decode($_COOKIE['user'], VariablesGlobales::KEY)->isAdmin == true) { ?>
                <div class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-primary" href="admin/gestion_article/creation_article" id="btn-ajout-news" >Ecrire un article</a>
                    </div>
                </div>        


                <?php
                $i = 1;
                foreach (VariablesGlobales::$lesarticles as $unarticle) {
                    $date = explode(" ", $unarticle->datearticle);
                    $jj_mm_aa = explode("-", $date[0]);
                    ?>
                    <div class="row" style="border-top: 1px solid #c0c0c0; margin-top: 8px;">


                        <div class="col-lg-2">
                            <div class="row">
                                <aside class="col-lg-12" style="margin-top: 25px">
                                    <?php echo $jj_mm_aa[2] . "/" . $jj_mm_aa[1] . "/" . $jj_mm_aa[0]; ?>
                                </aside>
                            </div>
                            <div class="row">
                                <aside class="col-lg-12" style="margin-top: 25px;">
                                    <form action="admin/gestion_article/supprimer_article" method="post">
                                        <input name="btnSuppr<?php echo $i ?>" class="btn btn-danger" type="submit" value="Supprimer l'article">
                                    </form>
                                    <form action="admin/gestion_article/modifier_article/<?php echo $unarticle->idarticle ?>" method="post">
                                        <input name="btnEdit" class="btn btn-danger" type="submit" value="Editer l'article">
                                    </form>
                                </aside>
                            </div>
                            <?php $i = $i + 1; ?>
                        </div>

                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-12">     
                                    <h1 style="color: #0066FF;"> <?php echo $unarticle->titre ?> </h1>
                                </div>              
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php echo $unarticle->resumearticle ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>                                               
</section>

