<!doctype html>

<html class="no-js" lang="en">
<head><!-- Header informatie -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eenmaal-Andermaal : <?php echo $pagename; ?></title>
    <link rel="stylesheet" crossorigin="anonymous" integrity="sha256-RYMme8QITYCPWDLzOXswkTsPu1tjeAE2Myb7Kid/JBY="
          href="https://cdn.jsdelivr.net/foundation-icons/3.0/foundation-icons.min.css">
    <link rel="stylesheet" href="/css/app.css">

    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/manifest.json">
    <link rel="mask-icon" href="/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
</head>
<body>

<!-- Title-bar -->
<div class="title-bar" data-responsive-toggle="navigatie-menu" data-hide-for="large">
    <button class="menu-icon" type="button" data-toggle="offCanvasLeft"></button>
    <span class="title-bar-title"><a href="/"><img src="img/logo/logo-sm.svg" alt="" class="brand-logo"></a></span>
</div>

<!-- Navigatie menu -->
<div class="top-bar" id="navigatie-menu">
    <!-- Linker menu -->
    <div class="top-bar-left">
        <ul class="dropdown vertical medium-horizontal menu" data-dropdown-menu>
            <!-- Logo -->
            <li class="hide-for-small-only"><a href="/"><img src="img/logo/logo.svg" alt="logo" class="brand-logo"></a></li>
            <!-- Link naar categoriepagina -->
            <li class="hide-for-small-only"><a href="categoriepagina.php">Bekijk Categorieën</a></li>
        </ul>
    </div>
    <!-- Rechter menu -->
    <div class="top-bar-right">
        <div class="menu">
            <!-- Categorie menu -->
            <div class="categorie"></div>
            <!-- Search veld -->
            <div><input type="search" placeholder="Zoekterm"></div>
            <div><button type="button" class="button submit"><span class="fi-magnifying-glass"></span> Zoeken</button></div>
            <div>
                <!-- Dropdown menu voor pagina's -->
                <ul class="account dropdown vertical medium-horizontal menu" data-dropdown-menu>
                    <li>
                        <a href="#"><span class="fi-torso"></a>
                        <ul class="menu noBorder">
                            <?php
                            //Pagina's worden afgeschermd en getoond voor de juiste soort gebruikers
                            if (isset($_SESSION['gebruiker']) && !empty($_SESSION['gebruiker'])) {
                                $adminCheck = executeQuery("SELECT TOP 1 admin FROM gebruikers WHERE gebruikersnaam = ?", [$_SESSION['gebruiker']]);
                                if ($adminCheck['code'] == 0) {
                                    $adminCheck = $adminCheck['data'][0]['admin'];
                                }
                                if ($adminCheck) {
                            ?>
                                    <li><a href="../../admin.php">Admin</a></li>
                                <?php } else {?>
                                    <li><a href="aanmakenveiling.php">Nieuwe veiling</a></li>
                                <?php } ?>
                                    <li><a href="profiel.php">Mijn profiel</a></li>
                            <li><a href="#" class="logoutButton">Uitloggen</a></li>
                            <?php } else { ?>
                            <li><a href="#" class="login_button">Log in</a></li>
                            <li><a href="#" class="signup_button">Aanmelden</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="off-canvas-wrapper">
    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
        <div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas>
            <div class="row column">
                <img src="img/logo/logo.svg" alt="logo" class="brand-logo">
            </div>
            <div class="row column">
                <h4>Pagina's</h4>
                <ul class="menu vertical">
                    <li><a href="categoriepagina.php">Bekijk Categoriën</a></li>
                </ul>
            </div>
            <div class="row column">
                <h4>Gegevens</h4>
                <ul class="menu vertical">
                <?php
                    if (isset($_SESSION["gebruiker"]) && !empty($_SESSION["gebruiker"])) {
                        $adminCheck = executeQuery("SELECT admin FROM gebruikers WHERE gebruikersnaam = ?", [$_SESSION["gebruiker"]]);
                        if ($adminCheck["code"] == 0) {
                            $adminCheck = $adminCheck["data"][0]["admin"];
                        }
                        if ($adminCheck) {
                            echo("<li><a href='admin.php'>Admin</a></li>");
                        } else {
                            echo("  <li><a href='aanmakenVeiling.php'>Nieuwe Veiling</a></li>
                                    <li><a href='profiel.php'>Mijn profiel</a></li>");
                        }
                    } else {
                        echo("  <li><a class='login_button button'>Log In</a></li>
                                <li><a class='signup_button button hollow'>Aanmelden</a></li>");
                    }
                ?>                    
                </ul> 
            </div>
        </div>
    </div>
</div>

<?php
include("php/layout/login-popup.php");
?>