<?php
$conn = new mysqli("localhost", "root", "root", "obchod");
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
$conn->set_charset("utf8");

include "func.php";

$L2Arr = file_get_contents("hodnoceni.txt");
$exp = explode(":??¨§ů§:", $L2Arr);
$komentare = [];
foreach ($exp as $key => $value) {
    $rozdelene = explode(";ů-.,", $value);
    if ($rozdelene[0] != null && $rozdelene[1] != null && $rozdelene[2] != null) {
        $jmeno = $rozdelene[0];
        $procenta = $rozdelene[1];
        $koment = $rozdelene[2];
        array_push($komentare, "<blockquote><p>$koment</p><footer class=\"blockquote-footer\">$jmeno -> $procenta %</footer></blockquote>");
    }
}
$arrAsString = "";
foreach ($komentare as $key => $value) {
    $arrAsString .= $value . "!_:?_!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Úvodní stránka</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="logo.png" type="image/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body class="bg-white text-secondary text-center container-fluid" onload="nacti()">
    <script>
        let clicked = false;

        let cislo;

        let str = <?php echo json_encode($arrAsString); ?>;

        let komentareArr = str.split("!_:?_!");
        komentareArr.pop();

        let pred = function pred() {
            clicked = true;
            if (cislo == 0) {
                return;
            }
            document.getElementById("aktualniKomentar").innerHTML = komentareArr[--cislo];
            document.getElementById("cisloKomentare").innerHTML = "" + ++cislo + " / " + komentareArr.length;
            cislo--;
        }

        let dalsi = function dalsi() {
            clicked = true;
            if (cislo >= komentareArr.length - 1) {
                return;
            }
            document.getElementById("aktualniKomentar").innerHTML = komentareArr[++cislo];
            document.getElementById("cisloKomentare").innerHTML = "" + ++cislo + " / " + komentareArr.length;
            cislo--;
        }

        let nacti = function nacti() {
            if (clicked === true) {
                return;
            }
            if (komentareArr.length === 0) {
                document.getElementById("aktualniKomentar").innerHTML = "Nemáme žádné komentáře";
                return;
            }
            cislo = Math.floor(Math.random() * komentareArr.length);
            document.getElementById("aktualniKomentar").innerHTML = komentareArr[cislo];
            document.getElementById("cisloKomentare").innerHTML = "" + ++cislo + " / " + komentareArr.length;
            cislo--;
        }
        setInterval(() => {
            nacti();
        }, 3500);
    </script>
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
            <p id="uvod">
                Vítejte na webových stránkách obchodu. Můžete zde vyhledávat produkty, jejich množství na skladě a jejich cenu. Dále se můžete registrovat do našeho systému a na jakkékoli prodejně si po registraci zažádat o zákaznickou kartu, která vám bude přinášet nespočet výhod při nakupování. Vzhled a funkčnost našich stránek můžete ohodnotit<a href="hodnoceni.php">zde.</a>
            </p>
            <h4>
                Co si o nás lidé myslí?
            </h4>
            <h6 id="cisloKomentare">

            </h6>
            <div class="row">
                <div class="col-sm-3">
                    <button class="btn btn-primary" onclick="pred()">Předchozí</button>
                </div>
                <div class="col-sm-6" id="aktualniKomentar">

                </div>
                <div class="col-sm-3">
                    <button class="btn btn-primary" onclick="dalsi()">Další</button>
                </div>
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
    </div>

</body>

</html>