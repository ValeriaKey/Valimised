<?php
    $serverinimi="d101718.mysql.zonevs.eu"; // d101718.mysql.zonevs.eu
    $kasutaja="d101718_valeriak"; // d101718_valeriak
    $parool="ValeriaK778010"; // ValeriaK778010
    $andmebaas="d101718_valeria20"; // d101718_valeria20
    $yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas );
    $yhendus->set_charset("UTF8");

if (isset($_REQUEST["haal"])){
    $kask=$yhendus->prepare('UPDATE valimised SET punktid=punktid+1 WHERE id=? ');
    $kask->bind_param("i", $_REQUEST["haal"]);
    $kask->execute();

    header("Location: $_SERVER[PHP_SELF]");
    die();
}
// lisamine
if (!empty($_REQUEST['nimi'])) {
    $kask=$yhendus->prepare('INSERT INTO valimised(nimi,lisamisaeg,punktid) VALUES(?, NOW(), 0)');
    $kask->bind_param('s', $_REQUEST['nimi']);
    $kask->execute();
    //$message = "Kandidaat on lisatud";
    //echo "<script type='text/javascript'>alert('$message');</script>";
    header("Location: kommenteerimine.php");
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
                    <li><a href="index.php" >Valimiste leht</a></li>
                    <li><a href="haldus.php">Haldus</a></li>
                    <li><a href="kommenteerimine.php">Kasutajale</a></li>
                    <li><a href="../PHPLeht">PHPLehestik</a></li>
                </ul>
            </nav>
            <div class="container-header">
            <h1>Tere tulemast!</h1>
            <h2>Kui te tahate osaleda valimises, siis lisa oma erakonna nimi!</h2>
            <p>Sellel lehel te saate vaadata kõik osalejad.</p>
            <p>Tänapäeval liiderid on <span>Keskerakond</span> ja <span>Sotsiaaldemorkaadid</span>. </p>
            </div>
    </header>
    <main>
        <div class="container">

            <article>
                <img src="img/keskerakond.jpg" alt="Keskerakond" id="keskerakond">
                <div class="text">
                <h3>KESKERAKOND</h3>
                <p>Eesti Keskerakond on suurim erakond Eestis, meie ridadesse kuulub hetkel üle 14 900 Eesti Vabariigi kodaniku. Me koondusime ühtseks erakonnaks 1991. aastal, Eestimaa Rahvarinde kaudu.

                    Oleme kaitsnud ja ellu viinud oma seisukohti, otsinud ja leidnud selliseid poliitilisi lahendusi, mis on aidanud Eesti ühiskonnal astuda demokraatlike riikide perre inimkaotusteta ja verd valamata. Oleme humanistlike eesmärkidega ühendus ja tahame kindlustada poliitiliste otsuste ning demokraatlike reformide kaudu eesti rahvale turvalise elu Eestis ja maailma rahvaste hulgas.</p>
                </div>
                </article>
                <article>
                <img src="img/sotsialdemokraadid.png" alt="Sotsialdemokraadid" id="sotsid">
                <div class="text-sotsid">
                <h3>SOTSIAALDEMOKRAADID</h3>
                <p>Sotsiaaldemokraatlikku Erakonda kuulub üle 5500 liikme, kes ei unusta, et kõige tähtsam on väärtustada inimest.

Riigist pole kasu, kui ta on rikas, aga rumal. Eestlased ei pea minema õnne otsima laia maailma. Kui tahad muuta Eesti ausaks riigiks, kus kõigil on hea elada ja arvad nagu sotsiaaldemokraadid, et kõige tähtsam on inimene ning väärtustad samuti võrdsust, õiglust ja solidaarsust, siis ühine meiega.</p>
                </div>
                </article>
            <h2>Kandidaadi lisamine:</h2>
            <form action="" method="post" class="kand-lisamine" name="nimi">
                <input type="text" placeholder="Nimi" name="nimi">
                <input type="submit" value="Lisa">
            </form>
                <h2>Kõik kandidaadid:</h2>
                <?php
                // valimiste tabeli sisu vaatamine andmebaasist

                $kask=$yhendus->prepare('SELECT id, nimi, punktid FROM valimised WHERE avalik=1 ');
                $kask->bind_result($id, $nimi, $punktid);
                $kask->execute();
                echo "<table>";
                echo "<tr><th>Nimi</th><th>Punktid</th></tr>";
                while($kask->fetch()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($nimi) . "</td>";
                    echo "<td>" . $punktid . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                ?>
        </div>
    </main>
    <footer>
            <p> © 2021 - Eesti Valimised. All Rights Reserved</p>
    </footer>
</body>
</html>