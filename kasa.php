<?php
$conn = new mysqli("localhost", "horeso", "MisujPhaHetofs6", "users_horeso");
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
$conn->set_charset("utf8");

include "func.php";

$polozkyslq = $conn->query("SELECT kod, cena, sklad FROM produkty;");
$polozky = [];
while ($row = $polozkyslq->fetch_array(MYSQLI_NUM)) {
    array_push($polozky, $row);
}
//$polozpolozky = mysqli_fetch_all($polozkysql); // zde je chyba při mysqli_fetch_all
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kasa</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="logo.jpg" type="image/jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body class="bg-white text-secondary text-center container-fluid">
    <script>
        let kosik = [];
        let sklad = [];
        let polozky = <?php echo json_encode($polozky); ?>;

        function addToCart(kod) {
            let cena, inv;
            polozky.forEach(element => {
                if (element[0] == kod) {
                    cena = element[1];
                    inv = element[2];
                }
            });
            if (kosik[kod] === undefined) {
                kosik[kod] = 0;
                sklad[kod] = inv;
            }
            if (sklad[kod] != 0) {
                document.getElementById("kosik-" + kod).innerHTML = ++kosik[kod];
                document.getElementById("sklad-" + kod).innerHTML = --sklad[kod];
            } else {
                document.getElementById("kup-" + kod).innerHTML = "Vyprodáno";
            }
        }
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
            <form action="" method="post">
                <div class="form-group">
                    <label for="jmeno_produktu">Název produktu:</label>
                    <input type="text" class="form-control" name="jmeno_produktu" id="jmeno_produktu" placeholder="Název">
                </div>
                <div class="form-group">
                    <label for="kod_produktu">Kód produktu:</label>
                    <input type="text" class="form-control" name="kod_produktu" id="kod_produktu" placeholder="Kód">
                </div>
                <div class="btn-group m-1">
                    <button type="submit" class="btn btn-primary" name="vyhledat">Vyhledat produkt</button>
                    <button type="submit" class="btn btn-primary" name="vyhledatcena">Vyhledat produkt (cena)</button>
                    <button type="submit" class="btn btn-primary" name="vyhledatnazev">Vyhledat produkt (název)</button>
                    <button type="submit" class="btn btn-primary" name="vyhledatkod">Vyhledat produkt (kód)</button>
                </div> <br>
                <div class="btn-group m-1">
                    <button type="submit" class="btn btn-primary" name="vse">Všechny produkty</button>
                    <button type="submit" class="btn btn-primary" name="cena">Všechny produkty (cena)</button>
                    <button type="submit" class="btn btn-primary" name="nazev">Všechny produkty (název)</button>
                    <button type="submit" class="btn btn-primary" name="kod">Všechny produkty (kód)</button>
                </div> <br>
                <div class="btn-group m-1">
                    <button type="submit" class="btn btn-primary" name="prumercenavse">Průměrná cena všech produktů</button>
                    <button type="submit" class="btn btn-primary" name="prumercenavyhledat">Průměrná cena vyhledaných produktů</button>
                </div> <br>
                <div>
                    <button type="submit" class="btn btn-primary m-1" name="placeni">Zaplatit</button>
                </div>
                <?php
                if (isset($_POST['prumercenavyhledat'])) {
                    $pocet = 0;
                    $celkem = 0;
                    if (empty($_POST["jmeno_produktu"]) and empty($_POST["kod_produktu"])) {
                        echo "musíš zadat jméno nebo kód produktu";
                        return;
                    } else {
                        if (!empty($_POST["kod_produktu"]) && empty($_POST["jmeno_produktu"])) {
                            $kod = $_POST["kod_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE kod LIKE '%$kod%';");
                            $kody = [];
                            while ($row = $result->fetch_row()) {
                                array_push($kody, $row[1]);
                                $pocet++;
                                $celkem += $row[3];
                            }
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                        if (!empty($_POST["jmeno_produktu"]) && empty($_POST["kod_produktu"])) {
                            $jmeno = $_POST["jmeno_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE jmeno LIKE '%$jmeno%';");
                            $kody = [];
                            while ($row = $result->fetch_row()) {
                                array_push($kody, $row[1]);
                                $pocet++;
                                $celkem += $row[3];
                            }
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                        if (!empty($_POST["jmeno_produktu"]) && !empty($_POST["kod_produktu"])) {
                            $jmeno = $_POST["jmeno_produktu"];
                            $kod = $_POST["kod_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE jmeno LIKE '%$jmeno%' AND kod LIKE '%$kod%';");
                            $kody = [];
                            while ($row = $result->fetch_row()) {
                                array_push($kody, $row[1]);
                                $pocet++;
                                $celkem += $row[3];
                            }
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                    }
                    if ($pocet == 0) {
                        echo "Nebyly nalezeny žádné produkty s danými parametry";
                    } else {
                        $prumer = $celkem / $pocet;
                        echo "<h4 class\"m-2\">Průměrná cena vyhledaných produktů je: $prumer Kč</h4>";
                    }
                }
                if (isset($_POST['prumercenavse'])) {
                    $pocet = 0;
                    $celkem = 0;
                    $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty;");
                    $kody = [];
                    while ($row = $result->fetch_row()) {
                        array_push($kody, $row[1]);
                        $pocet++;
                        $celkem += $row[3];
                    }
                    echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                    if ($pocet == 0) {
                        echo "Nemáme žádné produkty?????????????????????? (asi se špatně načetla databáze)";
                    } else {
                        $prumer = $celkem / $pocet;
                        echo "<h4 class\"m-2\">Průměrná cena vyhledaných produktů je: $prumer Kč</h4>";
                    }
                }
                if (isset($_POST['vyhledat'])) {
                    if (empty($_POST["jmeno_produktu"]) and empty($_POST["kod_produktu"])) {
                        echo "musíš zadat jméno nebo kód produktu";
                    } else {
                        if (!empty($_POST["kod_produktu"]) && empty($_POST["jmeno_produktu"])) {
                            $kod = $_POST["kod_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE kod LIKE '%$kod%';");
                            $kody = pushKody($result);
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                        if (!empty($_POST["jmeno_produktu"]) && empty($_POST["kod_produktu"])) {
                            $jmeno = $_POST["jmeno_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE jmeno LIKE '%$jmeno%';");
                            $kody = pushKody($result);
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                        if (!empty($_POST["jmeno_produktu"]) && !empty($_POST["kod_produktu"])) {
                            $jmeno = $_POST["jmeno_produktu"];
                            $kod = $_POST["kod_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE jmeno LIKE '%$jmeno%' AND kod LIKE '%$kod%';");
                            $kody = pushKody($result);
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                    }
                }
                if (isset($_POST['vyhledatkod'])) {
                    if (empty($_POST["jmeno_produktu"]) and empty($_POST["kod_produktu"])) {
                        echo "musíš zadat jméno nebo kód produktu";
                    } else {
                        if (!empty($_POST["kod_produktu"]) && empty($_POST["jmeno_produktu"])) {
                            $kod = $_POST["kod_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE kod LIKE '%$kod%' ORDER BY kod;");
                            $kody = pushKody($result);
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                        if (!empty($_POST["jmeno_produktu"]) && empty($_POST["kod_produktu"])) {
                            $jmeno = $_POST["jmeno_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE jmeno LIKE '%$jmeno%' ORDER BY kod;");
                            $kody = pushKody($result);
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                        if (!empty($_POST["jmeno_produktu"]) && !empty($_POST["kod_produktu"])) {
                            $jmeno = $_POST["jmeno_produktu"];
                            $kod = $_POST["kod_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE jmeno LIKE '%$jmeno%' AND kod LIKE '%$kod%' ORDER BY kod;");
                            $kody = pushKody($result);
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                    }
                }
                if (isset($_POST['vyhledatnazev'])) {
                    if (empty($_POST["jmeno_produktu"]) and empty($_POST["kod_produktu"])) {
                        echo "musíš zadat jméno nebo kód produktu";
                    } else {
                        if (!empty($_POST["kod_produktu"]) && empty($_POST["jmeno_produktu"])) {
                            $kod = $_POST["kod_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE kod LIKE '%$kod%' ORDER BY jmeno;");
                            $kody = pushKody($result);
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                        if (!empty($_POST["jmeno_produktu"]) && empty($_POST["kod_produktu"])) {
                            $jmeno = $_POST["jmeno_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE jmeno LIKE '%$jmeno%' ORDER BY jmeno;");
                            $kody = pushKody($result);
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                        if (!empty($_POST["jmeno_produktu"]) && !empty($_POST["kod_produktu"])) {
                            $jmeno = $_POST["jmeno_produktu"];
                            $kod = $_POST["kod_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE jmeno LIKE '%$jmeno%' AND kod LIKE '%$kod%' ORDER BY jmeno;");
                            $kody = pushKody($result);
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                    }
                }
                if (isset($_POST['vyhledatcena'])) {
                    if (empty($_POST["jmeno_produktu"]) and empty($_POST["kod_produktu"])) {
                        echo "musíš zadat jméno nebo kód produktu";
                    } else {
                        if (!empty($_POST["kod_produktu"]) && empty($_POST["jmeno_produktu"])) {
                            $kod = $_POST["kod_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE kod LIKE '%$kod%' ORDER BY cena;");
                            $kody = pushKody($result);
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                        if (!empty($_POST["jmeno_produktu"]) && empty($_POST["kod_produktu"])) {
                            $jmeno = $_POST["jmeno_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE jmeno LIKE '%$jmeno%' ORDER BY cena;");
                            $kody = pushKody($result);
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                        if (!empty($_POST["jmeno_produktu"]) && !empty($_POST["kod_produktu"])) {
                            $jmeno = $_POST["jmeno_produktu"];
                            $kod = $_POST["kod_produktu"];
                            $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty WHERE jmeno LIKE '%$jmeno%' AND kod LIKE '%$kod%' ORDER BY cena;");
                            $kody = pushKody($result);
                            echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                        }
                    }
                }
                if (isset($_POST['vse'])) {
                    $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty;");
                    $kody = pushKody($result);
                    echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                }
                if (isset($_POST['cena'])) {
                    $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty ORDER BY cena;");
                    $kody = pushKody($result);
                    echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                }
                if (isset($_POST['kod'])) {
                    $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty ORDER BY kod;");
                    $kody = pushKody($result);
                    echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                }
                if (isset($_POST['nazev'])) {
                    $result = $conn->query("SELECT id, kod, jmeno, cena, sklad FROM produkty ORDER BY jmeno;");
                    $kody = pushKody($result);
                    echo TableFrom2DArrayCustom1(["id", "kód", "jméno", "cena", "počet kusů na skladě"], $result, $kody);
                }
                if (isset($_POST['placeni'])) {
                    echo "Děkujeme za váš nákup.";

                    // SQL -> UPDATE produkty SET sklad = xxx WHERE kod = xxx;
                }
                ?>
            </form>
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