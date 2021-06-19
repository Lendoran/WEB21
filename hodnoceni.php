<?php
$conn = new mysqli("localhost", "horeso", "MisujPhaHetofs6", "users_horeso");
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
    <title>Hodnocení</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="logo.png" type="image/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body class="bg-white text-secondary text-center container-fluid">
    <div class="row header">
        <div class="col-md-2">
            <img src="logo.png" alt="logo firmy" class="img-fluid">
        </div>
        <div class="col-md-10">
            <h1>Webový portál firmy Obchod</h1>
        </div>
    </div>
    <div class="row secondRow">
        <div class="col-md-3 container-fluid sidebar">
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
        <div class="col-md-9 bg-lime p-3 content-form">
            <form action="" method="get">
                <div class="form-group" id="rangeBox">
                    <label for="jmeno_hodnoceni">Vaše jméno:</label>
                    <input type="text" class="form-control" name="jmeno_hodnoceni" id="jmeno_hodnoceni" placeholder="Jméno">
                </div>
                <div class="form-group">
                    <label for="hodnota_hodnoceni">Hodnocení v procentech spokojenosti </label><output style="left: 50%" class="" id="bubble">: 50%</output>
                    <input id="range" class="custom-range" type="range" name="hodnota_hodnoceni" min="0" max="100" value="50">
                </div>
                <script>
                    const range = document.getElementById("range");
                    const bubble = document.getElementById("bubble");

                    range.addEventListener("input", () => {
                        setBubble(range, bubble);
                    });

                    function setBubble(range, bubble) {
                        const val = range.value;
                        bubble.innerHTML = ": " + val + "%";
                    }
                </script>
                <div class="form-group">
                    <label for="komentar_hodnoceni">Komentář (dobrovolný) :</label>
                    <textarea id="komentar_hodnoceni" class="form-control" name="komentar_hodnoceni" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="odeslat_hodnoceni">Odeslat hodnocení</button>
            </form>
            <?php
            if (isset($_GET["odeslat_hodnoceni"])) {
                if (!empty($_GET["jmeno_hodnoceni"])) {
                    if ((!empty($_GET["hodnota_hodnoceni"]) and ($_GET["jmeno_hodnoceni"] >= 0) and ($_GET["jmeno_hodnoceni"] < 101))) {
                        if (empty($_GET["komentar_hodnoceni"])) {
                            $komentar = "bez komentáře";
                        } else {
                            $komentar = $_GET["komentar_hodnoceni"];
                        }
                        $jmeno = $_GET["jmeno_hodnoceni"];
                        $hodnoceni = $_GET["hodnota_hodnoceni"];
                        $file = fopen("hodnoceni.txt", "a") or die("nepodařilo se otevřít soubor s hodnocením");
                        fwrite($file, "$jmeno;ů-.,$hodnoceni;ů-.,$komentar:??¨§ů§:");
                        fclose($file);
                        echo "Komentář byl úspěšně zapsán. Děkujeme za ohodnocení!";
                    } else {
                        echo "Musíš zadat hodnotu hodnocení";
                    }
                } else {
                    echo "Musíš zadat svoje jméno";
                }
            }
            ?>
            <div class="m-4">
                <h5>Všechny naše komentáře si můžete přečíst <a href="index.php">zde</a></h5>
            </div>
        </div>
    </div>
    <div class="row footer">
        <div class="col-md-12">
            <h4>Portál společnosti Obchod, vytvořen 19.5.2021. Dnes je
                <?php date_default_timezone_set('Europe/Prague');
                echo date('d.m.Y G:i:s'); ?>
            </h4>
        </div>
        <a href="zadani.html" class="col-md-12">zadání</a>
    </div>
</body>

</html>