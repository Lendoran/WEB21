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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hodnocení</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="logo.png" type="image/png">
</head>

<body class="container">
    <div class="header">
        <img src="logo.png" alt="logo firmy">
        <div>
            <h1>Webový portál firmy Obchod</h1>
        </div>
    </div>
    <div class="sidebar sidebartext">
        <a href="index.php">Úvodní stránka</a>
        <a href="vyhledavani.php">Vyhledání produktu</a>
        <a href="kasa.php">Kasa</a>
        <a href="registrace.php">Registrace</a>
        <a href="hodnoceni.php">hodnocení stránky</a>
    </div>
    <div class="topbar ">
        <div class="topbartext">
            <h3>Hodnocení webových stránek</h3>
        </div>

    </div>
    <div class="content">
        <form action="" method="get">
            <table>
                <tr>
                    <td>
                        <label for="jmeno_produktu">Jméno produktu</label>
                    </td>
                    <td>
                        <input type="text" name="jmeno_produktu">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="jmeno_produktu">Kód produktu</label>
                    </td>
                    <td>
                        <input type="text" name="kod_produktu">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" name="vyhledat">Vyhledat produkt</button>
                    </td>
                </tr>
            </table>
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
    <div class="footer footertext">
        <p>Portál společnosti Obchod, vytvořen 19.5.2021. Dnes je
            <?php date_default_timezone_set('Europe/Prague');
            echo date('d.m.Y G:i:s'); ?>
        </p>
    </div>
</body>

</html>