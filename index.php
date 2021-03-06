<?php
//page variables
$pagename = "home";

include("php/core.php");
include("php/layout/header.php");
?>
<main class="home">
    <div class="banner">
        <div class="inner row">
            <div class="background column small-8 medium-8 large-6">
                <h3><span>Eenmaal-Andermaal</span> Koop een uniek geschenk<br>of verkoop je eigen spullen</h3>
                <div class="big-search row">
                    <div class="column medium-5" id="blocks">
                        <input type="text" placeholder="zoekterm">
                    </div>
                    <div class="column medium-5 categorieselect" id="blocks">
                    </div>
                    <div class="column medium-2" id="blocks">
                        <input type="submit" class="button submit" value="Submit">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="veilingen row">
        <div class="clearfix">
            <h4 class="float-left" id="trending">Trending</h4>
            <a id="trendingButton" href="categoriepagina.php" class="button hollow float-right">View more ></a>
        </div>
        <hr>
        <div class="trendingData small-up-2 medium-up-3 large-up-6 columns-12" data-equalizer>
        </div>
    </div>
</main>


<?php include("php/layout/footer.html"); ?>
<script>
    //Ophalen van de trending veilingen
    function trending(){
        $.post("/php/api.php?action=trending",function(result){
            var target = ".veilingen .trendingData";
            veiling(target, result);
        });
    }
    $(document).ready(function(){
        trending();
    });
</script>
</body>
</html>