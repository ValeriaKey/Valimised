<?php
    $serverinimi="d101718.mysql.zonevs.eu"; // d101718.mysql.zonevs.eu
    $kasutaja="d101718_valeriak"; // d101718_valeriak
    $parool="ValeriaK778010"; // ValeriaK778010
    $andmebaas="d101718_valeria20"; // d101718_valeria20
    $yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas );
    $yhendus->set_charset("UTF8");

if (isset($_REQUEST['uus_kommentaar'])) {
    $kask=$yhendus->prepare('UPDATE valimised SET kommentaarid=CONCAT(kommentaarid, ?) WHERE id=?');
    $kommentlisa = $_REQUEST['komment']."\n";
    $kask->bind_param('si', $kommentlisa, $_REQUEST['uus_kommentaar']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    die();
}
if (isset($_REQUEST["haal"])){
    $kask=$yhendus->prepare('UPDATE valimised SET punktid=punktid+1 WHERE id=? ');
    $kask->bind_param("i", $_REQUEST["haal"]);
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
    <title>Kommenteerimine</title>
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
            <h1>Lehekülg Kasutajale</h1>
            <h2>Andke oma hääl ja kommentaar!</h2>
            <p>Sellel lehel te saate vaadata kommentaare erakondadest, kommenteerida ja anna oma hääle.</p>
            </div>
    </header>
    <main>
        <div class="container">
                <h1>Kõik kandidaadid:</h1>

<?php
// valimiste tabeli sisu vaatamine andmebaasist
                $kask=$yhendus->prepare('SELECT id, nimi, punktid, kommentaarid FROM valimised WHERE avalik=1 Order By Punktid Desc');
                $kask->bind_result($id, $nimi, $punktid, $kommentaarid);
                $kask->execute();
                echo "<table>";
                echo "<tr><th>Nimi</th><th>Punktid</th><th>Anna oma hääl</th><th>Kommentaarid</th></tr>";
                while($kask->fetch()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($nimi) . "</td>";
                    echo "<td>" . $punktid . "</td>";
                    echo "<td><a class='haal' href='?haal=$id'> Lisa +1 punkt</a></td>";
                    echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
                    echo "<td>
<form action='?'>
<input type='hidden' name='uus_kommentaar' value='$id'>
<input type='text' name='komment' class='kommentaari'>
<input type='submit' value='Lisa kommentaar'>
</form></td>";

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