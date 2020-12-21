<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Document</title>
    <link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface|Happy+Monkey|Arima+Madurai|Anton|Fjalla+One|Noto+Sans|Play|Playfair+Display|Poppins|Lobster Two" rel="stylesheet">  
    <link href="stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="page-wrap">
<div id = header>
    <a href="korpa.php" title="korpa">
        <div id=divkorpa>
            <img src="images/korpa.png">
                <p id="suma">
                <?php if(isset($_SESSION['stavke'])) {
                            if ($_SESSION['korpa'] > 0.1) {
                                echo $_SESSION['korpa'] . " din.";
                                }
                                else {
                                    echo "0 din.";
                                }
                        } else {
                            echo "0 din.";
                        }
                ?>
                </p>
        </div>
    </a>

    <ul class="headerLista">
        <?php if(!isset($_SESSION['user_id'])){ ?>
        <li><a href="registracija.php">Registracija</a></li>
        <li><a href="login.php">Prijava</a></li>
        <?php } else { ?>
        <li><a href="#"><?php echo $_SESSION['username']; ?></a></li>
        <li><a href="logout.php">Odjava</a></li>
        <li><a href="index.php">Proizvodi</a></li>
        <li><a href="korpa.php">Korpa</a></li>
        <li><a href="narudzbenice_korisnika.php">Moje Porudžbine</a></li>
        <?php } ?>
    </ul>
</div>

