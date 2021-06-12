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
    <title>portál Obchod</title>
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
            <h3>Úvodní stránka</h3>
        </div>

    </div>
    <div class="content">
        <?php
         echo "Co si o nás lidé myslí?";
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