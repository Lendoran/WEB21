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
        <form action="" method="get" oninput="output_hodnoceni.value=parseInt(hodnota_hodnoceni.value)">
            <table>
                <tr>
                    <td>
                        <label for="jmeno_hodnoceni">Vaše jméno: </label>
                    </td>
                    <td>
                        <input type="text" name="jmeno_hodnoceni">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="hodnota_hodnoceni">Hodnocení ( 100 => nejlepší ): </label>
                    </td>
                    <td>
                        0<input type="range" name="hodnota_hodnoceni" min="0" max="100" value="50">100 = 
                        <output name="output_hodnoceni" for="hodnota_hodnoceni"></output>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="komentar_hodnoceni">Komentář (dobrovolný) : </label>
                    </td>
                    <td>
                        <textarea type="text" name="komentar_hodnoceni" placeholder="Sem napište svůj komentář"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" name="odeslat_hodnoceni">Odeslat hodnocení</button>
                    </td>
                </tr>
            </table>
        </form>
        <?php
        if (!empty($_GET["jmeno_hodnoceni"])) {
            if ((!empty($_GET["hodnota_hodnoceni"]) and ($_GET["jmeno_hodnoceni"] >= 0 ) and ($_GET["jmeno_hodnoceni"] < 101))) {
                if (empty($_GET["komentar_hodnoceni"])) {
                    $komentar = "bez komentáře";
                } else {
                    $komentar = $_GET["komentar_hodnoceni"];
                }
                $jmeno = $_GET["jmeno_hodnoceni"];
                $hodnoceni = $_GET["hodnota_hodnoceni"];
                $file = fopen("hodnoceni.txt", "a") or die("nepodařilo se otevřít soubor s hodnocením");
                fwrite($file, "$jmeno;$hodnoceni;$komentar\n");
                fclose($file);
                echo "Komentář byl úspěšně zapsán";
            } else {
                echo "Musíš zadat hodnotu hodnocení";
            }
        } else {
            echo "Musíš zadat svoje jméno";
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