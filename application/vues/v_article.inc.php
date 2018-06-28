<section>
    <div id="article_autre">
        <div class="container">
            <?php if (isset($_COOKIE['user']) && JWT::decode($_COOKIE['user'])['isAdmin']==true){?>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-primary" href="index.php?controleur=news&action=ecrireArticle" id="btn-ajout-news" >Ecrire une news</a>
                </div>
            </div>        
            <?php } ?>

            <?php
            $i =1;
             foreach (VariablesGlobales::$lesarticles as $unarticle) {
                $date = explode(" ", $unarticle->date);
                $jj_mm_aa = explode("-", $date[0]);
                ?>
                <div class="row" style="border-top: 1px solid #c0c0c0; margin-top: 8px;">
                    
                    
                    <div class="col-lg-2">
                        <div class="row">
                            <aside class="col-lg-12" style="margin-top: 25px">
                                <?php echo $jj_mm_aa[0] . "/" . $jj_mm_aa[1] . "/" . $jj_mm_aa[2] . " " . $date[1]; ?>
                            </aside>
                        </div>
                        <?php if(isset($_SESSION['isAdmin']) && JWT::decode($_COOKIE['user'])['isAdmin']==true){?>
                        <div class="row">
                            <aside class="col-lg-12" style="margin-top: 25px;">
                                <form action="index.php?controleur=news&action=supprArticleFromAccueil" method="post">
                                    <input name="btnSuppr<?php echo $i?>" class="btn btn-danger" type="submit" value="Supprimer l'article">
                                </form>
                                  <form action="index.php?controleur=categorie&action=editerarticle&edit=<?php echo $unarticle->idarticle ?>" method="post">
                                            <input name="btnEdit" class="btn btn-danger" type="submit" value="Editer la catégorie">
                                  </form>
                            </aside>
                        </div>
                    <?php $i=$i+1; }?>
                    </div>
                    
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-12">     
                                <h1 style="color: #0066FF;"> <?php echo $unarticle->titre ?> </h1>
                            </div>              
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo $unarticle->resume ?>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php
                }?>
            </div>
        </div>                                               
</section>

