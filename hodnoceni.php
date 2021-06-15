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
    <title>Hodnocení</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="shortcut icon" href="logo.png" type="image/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body class="bg-white text-secondary text-center container-fluid">
    <div class="row">
        <div class="col-2">
            <img src="logo.png" alt="logo firmy" class="img-fluid">
        </div>
        <div class="col-10">
            <h1>Webový portál firmy Obchod</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2 container">
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
        <div class="col-sm-10 bg-warning p-3">
            <form action="" method="get">
                <!-- <table>
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
                </table> -->
                <div class="form-group" id="rangeBox">
                    <label for="jmeno_hodnoceni">Vaše jméno:</label>
                    <input type="text" class="form-control" name="jmeno_hodnoceni" id="jmeno_hodnoceni" aria-describedby="helpId" placeholder="Jméno">
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
    </div>
    <div class="row">
        <div class="col-md-12">
            <p>Portál společnosti Obchod, vytvořen 19.5.2021. Dnes je
                <?php date_default_timezone_set('Europe/Prague');
                echo date('d.m.Y G:i:s'); ?>
            </p>
        </div>
    </div>
</body>

</html>