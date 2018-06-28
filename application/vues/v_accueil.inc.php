<section>
    <div id="article_autre">
        <div class="container">


            <?php
            $i = 1;
            if(VariablesGlobales::$unarticle != NULL){
                $date = explode(" ", VariablesGlobales::$unarticle->datearticle);
                $jj_mm_aa = explode("-", $date[0]);
                ?>
                <div class="row" style="border-top: 1px solid #c0c0c0; margin-top: 8px;">


                    <div class="col-lg-2">
                        <div class="row">
                            <aside class="col-lg-12" style="margin-top: 25px">
                                <?php echo $jj_mm_aa[2] . "/" . $jj_mm_aa[1] . "/" . $jj_mm_aa[0]; ?>
                            </aside>
                        </div>

                    </div>

                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-12">     
                                <h1 style="color: #0066FF;"> <?php echo VariablesGlobales::$unarticle->titre ?> </h1>
                            </div>              
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo VariablesGlobales::$unarticle->contenuarticle ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }
            
            ?>
        </div>
    </div>                                               
</section>

