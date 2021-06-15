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
    <title>Kasa</title>
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
            <form action="" method="get">
                <div class="form-group" id="rangeBox">
                    <label for="jmeno_produktu">Název produktu:</label>
                    <input type="text" class="form-control" name="jmeno_produktu" id="jmeno_produktu" placeholder="Název">
                </div>
                <div class="form-group" id="rangeBox">
                    <label for="kod_produktu">Kód produktu:</label>
                    <input type="text" class="form-control" name="kod_produktu" id="kod_produktu" placeholder="Název">
                </div>
                <button type="submit" class="btn btn-primary" name="odeslat_hodnoceni">Vyhledat produkt</button>
            </form>
            <?php
            if (isset($_POST['vyhledat'])) {
                if (empty($_POST["jmeno_produktu"]) and empty($_POST["kod_produktu"])) {
                    echo "musíš zadat jméno nebo kód produktu";
                } else {
                    if (!empty($_POST["kod_produktu"])) {
                        $kod = $_POST["kod_produktu"];
                        $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE kod LIKE '%$kod%';");
                        $kody = [];
                        while ($row = $result->fetch_row()) {
                            array_push($kody, $row[0]);
                        }
                        echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                    }
                    if (!empty($_POST["jmeno_produktu"])) {
                        $jmeno = $_POST["jmeno_produktu"];
                        $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE jmeno LIKE '%$jmeno%';");
                        echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
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