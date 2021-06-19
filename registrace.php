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
    <title>Registrace</title>
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
            <form action="" method="post">
                <div class="form-group" id="rangeBox">
                    <label for="uzivatel_jmeno">Uživatelské jméno:</label>
                    <input type="text" class="form-control" name="uzivatel_jmeno" id="uzivatel_jmeno" placeholder="Uživatelské jméno">
                </div>
                <div class="form-group">
                    <label for="uzivatel_heslo">Heslo</label>
                    <input type="password" class="form-control" name="uzivatel_heslo" id="uzivatel_heslo" placeholder="heslo">
                </div>
                <div class="form-group">
                    <label for="uzivatel_heslo_znovu">Opakovat heslo</label>
                    <input type="password" class="form-control" name="uzivatel_heslo_znovu" id="uzivatel_heslo_znovu" placeholder="opakovat heslo">
                </div>
                <button type="submit" class="btn btn-primary" name="registrace">Registrovat</button>
            </form>
            <?php
            if (isset($_POST['registrace'])) {
                if (empty($_POST["uzivatel_jmeno"])) {
                    echo "musíš zadat uživatelské jméno";
                    return;
                }
                if (empty($_POST["uzivatel_heslo"])) {
                    echo "musíš zadat heslo";
                    return;
                }
                if (empty($_POST["uzivatel_heslo_znovu"])) {
                    echo "musíš zopakovat heslo";
                    return;
                }
                if ($_POST["uzivatel_heslo"] != $_POST["uzivatel_heslo_znovu"]) {
                    echo "hesla se neshodují";
                    return;
                }
                $uzivatel_jmeno = $_POST["uzivatel_jmeno"];
                $sql = "SELECT COUNT(1)
                    FROM uzivatele
                    WHERE uzivatel_jmeno = '$uzivatel_jmeno';";
                $result = $conn->query($sql);
                $result = mysqli_fetch_array($result, MYSQLI_NUM);
                if ($result == 1) {
                    echo "uživatelské jméno již existuje, zvolte prosím jiné";
                    return;
                }
                $crypto = hash("sha384", $_POST["uzivatel_heslo"]);
                $sql = "INSERT INTO uzivatele VALUES
                    (NULL, '$uzivatel_jmeno', '$crypto', '1');";
                $conn->query($sql);
                echo "Byl jste úspěšně zaregistrován";
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
        <a href="zadani.html" class="col-md-12">zadání</a>
    </div>
</body>

</html>