<?php
$pagename = "admin panel";
include("php/core.php");
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");
if (isset($_SESSION['gebruiker'])) {
    if ($adminCheck) {
        ?>
        <main class="row">
            <ul class="tabs" id="admintabs" data-active-collapse="true" data-tabs>
                <li class="tabs-title is-active"><a href="#overzicht">overzicht</a></li>
                <li class="tabs-title"><a href="#categorie">Categorie toevoegen</a></li>
                <li class="tabs-title"><a href="#veiling">Veiling</a></li>
                <li class="tabs-title"><a href="#sluitVeilingen">Sluit veilingen</a></li>
                <li class="tabs-title"><a href="#adminRechten">Wijzig admin</a></li>
            </ul>

            <div class="tabs-content" data-tabs-content="admintabs" data-active-collapse="true">
                <div class="tabs-panel" id="overzicht">
                    <div class="row expanded show-for-large">
                        <iframe style="width:100%; height:600px;"
                                src="https://app.powerbi.com/view?r=eyJrIjoiMzAxNzVlODktMDEyZC00NWZiLWJiYjUtNDY0ZjBjMzFjMzUyIiwidCI6ImI2N2RjOTdiLTNlZTAtNDAyZi1iNjJkLWFmY2QwMTBlMzA1YiIsImMiOjh9"
                                frameborder="0" allowFullScreen="true"></iframe>
                    </div><!--row expanded-->
                </div><!--overzicht-->
                <div class="tabs-panel categoriemanager" id="categorie">
                    <?php
                    include("php/layout/categorieToevoegen.php");
                    ?>
                </div><!--categorie-->
                <div class="tabs-panel" id="veiling">
                    <div class="column row">
                        <div class="input-group">
                            <input type="number" class="input-group-field" placeholder="veilingId" id="veilingId">
                            <div class="input-group-button">
                                <button id="zoekVeiling" class="button">Zoek</button>
                            </div><!--input group button-->
                        </div><!--input group-->
                    </div><!--column row-->
                    <hr>
                    <div class="column row">
                        <div class="float-right" id="knoppen"></div>
                        <div class="large reveal" id="verplaatsVeiling" data-reveal>
                            <h4>Selecteer categorie</h4>
                            <div id="categorieTwee"></div>
                            <button class="button alert" id="verplaats">Verplaats</button>
                            <button class="close-button" data-close aria-label="Close modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!--reveal-->
                        <div class="large reveal" id="verwijderVeiling" data-reveal>
                            <h4>Weet u zeker dat u de veiling wilt verwijderen?</h4>
                            <button class="button alert" id="verwijder">Verwijder</button>
                            <button class="close-button" data-close aria-label="Close modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!--reveal-->
                    </div><!--column row-->
                    <div class="row">
                        <div class="columns large-8" id="veilingInfo"></div>
                        <div class="columns large-4" id="veilingDatum"></div>
                    </div>
                </div><!--tabs panel veiling-->

                <div class="tabs-panel" id="sluitVeilingen">
                    <button class="button secondary">Sluit Veilingen</button>
                </div><!--sluitVeilngen-->

                <div class="tabs-panel" id="adminRechten">
                    <div class="column row">
                        <div class="input-group">
                            <input type="text" class="input-group-field" placeholder="Username" id="username">
                            <div class="input-group-button">
                                <button id="zoekUser" class="button">Zoek</button>
                            </div><!--input group button-->
                        </div><!--input-group-->
                    </div><!--column row-->
                    <div class="column row">
                        <div class="columns small-8" id="gebruikersInfo"></div>
                        <div class="columns small-4" id="adminKnoppen"></div>
                    </div><!--column row-->
                </div><!--adminRechten-->
            </div><!--admintabs-->
        </main>


        <?php
    }
    include("php/layout/geentoegang.html");
}
include("php/layout/geentoegang.html");
include("php/layout/footer.html");

?>
<script>
var veilingId;
var gebruikerGezocht;

    function gebruikersGegevens(){
        username = '<?php echo($_SESSION["gebruiker"]) ?>';
        console.log(username);
        gebruikerGezocht = $("#username").val();

        var gebruiker = {
            gebruikersnaam: $("#username").val()
        };

        $.ajax({
            type: "POST",
            url: "php/api.php?action=getGebruikersgegevens",
            data: gebruiker,
            dataType: "JSON",
            success: function(result){
                gebruiker = result.data[0];
                console.log(gebruiker);
                $("#gebruikersInfo").empty();
                $("#adminKnoppen").empty();
                $("#gebruikersInfo").append("<div>  <h1>"+gebruiker.gebruikersnaam+"</h1>"+
                                                    "<h5>"+gebruiker.voornaam+" "+gebruiker.achternaam+"</h5></div>"+
                                            "<div>  <p>"+gebruiker.geboortedatum+"</p></div>");
                if(gebruiker.gebruikersnaam != username){
                    if(gebruiker.admin == 1){
                        console.log(gebruiker.admin);
                        $("#adminKnoppen").append("<button class='button warning' onclick='admin()'>Verwijder als admin</button>");
                    } else{
                        $("#adminKnoppen").append("<button class='button warning' onclick='admin()'>Voeg toe als admin</button>");
                    }
                }
                
            }
        });
    }

    $("#zoekUser").click(function () {
        gebruikersGegevens();
    });
    function admin(){
        var gebruiker = {
            gebruikersnaam: gebruikerGezocht
        };

        $.ajax({
            type: "POST",
            url: "php/api.php?action=veranderAdminStatus",
            data: gebruiker,
            dataType: "JSON",
            complete: function(){
                gebruikersGegevens();
            }
        });
    }

    $("#addCategorieToDatabase").click(function () {
        var categorie = {
            categorieNaam: $('#categorieNaam').val(),
            superId: $(".categorien").children().last().prev().find(":selected").val()
        };

        $.ajax({
            type: "POST",
            url: "php/api.php?action=addCategorieToDatabase",
            data: categorie,
            dataType: "json",
            complete: function(){
                alert("Categorie toevoegen geslaagd!");
            }
        });
    });

    $("#zoekVeiling").click(function () {
        veilingId = $('#veilingId').val();
               
        var veiling = {
            veilingId: veilingId
        };
        $.ajax({
            type: 'POST',
            url: 'php/api.php?action=getVeilingInfo',
            data: veiling,
            dataType: 'json',
            success: function(result){
                veiling = result.data[0];
                
                $('#veilingInfo').empty();
                $('#veilingDatum').empty();
                $('#knoppen').empty();
                $('#veilingInfo').append("<div>  <h1>"+veiling.titel+"</h1>"+
                                                "<h5>"+veiling.verkoperGebruikersnaam+"</h5></div>"+
                                        "<div><img src='http://iproject34.icasites.nl/"+veiling.thumbNail+"' alt='img'></div>"+
                                        "<div><h4>Beschrijving:</h4><p>"+veiling.beschrijving+"</p></div>");

                $('#veilingDatum').append("<div><h4>Veiling eindigd op:</h4><span>"+veiling.eindDatum+"</span></div>");
                $('#knoppen').append("<button class='button secondary' data-open='verplaatsVeiling'>Verplaatsen</button>"+
                                    (veiling.veilingGestopt == false ? "<button class='button warning' id='beindigd' onclick='beindig()'>Beïndigen</button>": "")+
                                    "<button class='button alert' data-open='verwijderVeiling'>Verwijderen</button");
            }
        });
    });

    function beindig(){
        var veiling = {
            veilingId: veilingId
        };
        $.ajax({
                type: 'POST',
                url: 'php/api.php?action=beindigveiling',
                data: veiling,
                dataType: 'json',
                complete: function(){
                    alert('Veiling beïndigen geslaagd!');
                }
            });
            $('#beindigd').remove();
    }

    $('#verwijder').click(function(){
        var veiling = {
            veilingId: veilingId
        };
         $.ajax({
            type: 'POST',
            url: 'php/api.php?action=verwijderVeiling',
            data: veiling,
            dataType: 'json',
            complete: function(){
                alert('Veiling verwijderen geslaagd!');
            }
        });
        $('#verwijderVeiling').foundation('close');
        $('#veilingInfo').empty();
        $('#veilingDatum').empty();
        $('#knoppen').empty();
    });

    $('#verplaats').click(function(){
        var veiling = {
            veilingId: veilingId,
            categorieId: $('#categorieTwee').children().last().prev().find(":selected").val()
        };
        $.ajax({
            type: 'POST',
            url: 'php/api.php?action=verplaatsVeiling',
            data: veiling,
            dataType: 'json',
            complete: function(){
                $('#verplaatsVeiling').foundation('close');
                alert('Veiling verplaatsen geslaagd!');
            }
        });
    });

    $('#sluitVeilingen').click(function(){
        $.ajax({
            type: 'POST',
            url: 'php/api.php?action=sluitVeilingen',
            dataType: 'json'
        });
    });

</script>
</body>
</html>