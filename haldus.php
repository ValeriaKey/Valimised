<?php
$serverinimi="d101718.mysql.zonevs.eu"; 
$kasutaja="d101718_valeriak"; // d101718_valeriak
$parool="ValeriaK778010"; // ValeriaK778010
$andmebaas="d101718_valeria20"; // d101718_valeria20
$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas );
$yhendus->set_charset("UTF8");

// lisamine
if (!empty($_REQUEST['nimi'])) {
    $kask=$yhendus->prepare('INSERT INTO valimised(nimi,lisamisaeg,punktid) VALUES(?, NOW(), 0)');
    $kask->bind_param('s', $_REQUEST['nimi']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    die();
}
// Kustutamine
if (isset($_REQUEST["kustutamine"])) {
    $kask=$yhendus->prepare("DELETE FROM valimised WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustutamine"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    die();
}
// Annulleerima
if (isset($_REQUEST["annulleerimine"])){
    $kask=$yhendus->prepare('UPDATE valimised SET kommentaarid="",punktid=0 WHERE id=? ');
    $kask->bind_param("i", $_REQUEST["annulleerimine"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    die();
}
// peitmine, avalik = 0
if (isset($_REQUEST["peitmine"])){
    $kask=$yhendus->prepare('UPDATE valimised SET avalik=0 WHERE id=? ');
    $kask->bind_param("i", $_REQUEST["peitmine"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    die();
}
// avalikustamine, avalik = 1
if (isset($_REQUEST["avamine"])){
    $kask=$yhendus->prepare('UPDATE valimised SET avalik=1 WHERE id=? ');
    $kask->bind_param("i", $_REQUEST["avamine"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript">
        $(window).on('scroll', function() {
            if($(window).scrollTop()) {
                $('nav').addClass('black');
            }
            else {
                $('nav').removeClass('black');
            }
        })
    </script>
    <title>Document</title>
</head>
<body>
<header class="header">

    <nav>
        <div class="logo">
            <img src="logo5.png" alt="Something will be">
        </div>
        <ul>
            <li><a href="index.php">Valimiste leht</a></li>
            <li><a href="haldus.php">Haldus</a></li>
            <li><a href="kommenteerimine.php">Kasutajale</a></li>
            <li><a href="../PHPLeht">PHPLehestik</a></li>
        </ul>
    </nav>
    <div class="container-header">
        <h1>Administraatori haldus.</h1>
        <p class="ohtlik">Sellel lehel te saate annulleerida punkte ja kommentaare,<br> avada/peita kandidaadi ja kustuta neid.</p>
    </div>
</header>
<main>
    <div class="container">
        <h1>Kandidaadi kustutamine, punkte ja kommentaare annullerimine ja kandidaadi status.</h1>
        <?php

        $kask=$yhendus->prepare('SELECT id, nimi, avalik FROM valimised');
        $kask->bind_result($id, $nimi, $avalik);
        $kask->execute();
        echo "<table>";
        echo "<tr><th>Nimi</th><th>Status</th><th>Tegevus</th><th>Kustutamine</th><th>Annulleerimine(kommentaarid ja punktid)</th></tr>";
        while($kask->fetch()) {
            $avatekst = "Ava";
            $param = "avamine";
            $sesiund = "Avatud";
            if ($avalik == 1) {
                $avatekst = "Peida";
                $param = "peitmine";
                $seisund = "Avatud";
            } else if ($avalik == 0) {
                $avatekst = "Ava";
                $param = "avamine";
                $sesiund = "Peidetud";

            }
            echo "<tr>";
            echo "<td>" . htmlspecialchars($nimi) . "</td>";
            echo "<td>" . ($sesiund) . "</td>";
            echo "<td><a class='tegevus-btn' href='?$param=$id'> $avatekst </a></td>";
            echo "<td><a class='tegevus-btn' href='?kustutamine=$id'>Kustuta</a></td>";
            echo "<td><a class='tegevus-btn' href='?annulleerimine=$id'>Annulleerimine</a></td>";
            echo "</tr>";
        }
        echo "</table>";

        ?>

    </div>
</main>
<footer>
    <p> © 2021 - Eesti Valimised. All Rights Reserved</p>
</footer>
</div>
</main>
</body>

</html>