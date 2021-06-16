<?php
$conn = new mysqli("localhost", "root", "root", "obchod");
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
$conn->set_charset("utf8");

include "func.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vyhledání produktu</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="logo.png" type="image/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body class="bg-white text-secondary text-center container-fluid">
    <div class="row header">
        <div class="col-sm-2">
            <img src="logo.png" alt="logo firmy" class="img-fluid">
        </div>
        <div class="col-sm-10">
            <h1>Webový portál firmy Obchod</h1>
        </div>
    </div>
    <div class="row secondRow">
        <div class="col-sm-3 container sidebar">
            <div class=" row">
                <a href="index.php" class="col-12">Úvodní stránka</a>
            </div>
            <div class="row">
                <a href="vyhledavani.php" class="col-12">Vyhledání produktu</a>
            </div>
            <div class="row">
                <a href="kasa.php" class="col-12">Kasa</a>
            </div>
            <div class="row">
                <a href="registrace.php" class="col-12">Registrace</a>
            </div>
            <div class="row">
                <a href="hodnoceni.php" class="col-12">hodnocení stránky</a>
            </div>
        </div>
        <div class="col-sm-9 bg-lime p-3 content-form">
            <form action="vyhledavani.php" method="get">
                <div class="form-group" id="nazev">
                    <label for="jmeno_produktu">Název produktu:</label>
                    <input type="text" class="form-control" name="jmeno_produktu" id="jmeno_produktu" placeholder="Název">
                </div>
                <div class="form-group" id="kod">
                    <label for="kod_produktu">Kód produktu:</label>
                    <input type="text" class="form-control" name="kod_produktu" id="kod_produktu" placeholder="Kód">
                </div>
                <button type="submit" class="btn btn-primary" name="vyhledat">Vyhledat produkt</button>
            </form>
            <?php
            if (isset($_GET['vyhledat'])) {
                if (empty($_GET["jmeno_produktu"]) and empty($_GET["kod_produktu"])) {
                    echo "musíš zadat jméno nebo kód produktu";
                } else {
                    if (!empty($_GET["kod_produktu"])) {
                        $kod = $_GET["kod_produktu"];
                        $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE kod LIKE '%$kod%';");
                        echo TableFrom2DArray(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result);
                    }
                    if (!empty($_GET["jmeno_produktu"])) {
                        $jmeno = $_GET["jmeno_produktu"];
                        $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE jmeno LIKE '%$jmeno%';");
                        echo TableFrom2DArray(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result);
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="row footer">
        <div class="col-md-12">
            <h4>Portál společnosti Obchod, vytvořen 19.5.2021. Dnes je
                <?php date_default_timezone_set('Europe/Prague');
                echo date('d.m.Y G:i:s'); ?>
            </h4>
        </div>
    </div>
</body>

</html>