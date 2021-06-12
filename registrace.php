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
    <title>Registrace do systému Obchodu</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="logo.png" type="image/png">
</head>

<body class="container">
    <div class="header">
        <img src="logo.png" alt="logo firmy">
        <div class="center">
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
            <h3>Registrace do systému</h3>
        </div>

    </div>
    <div class="content">
        <form action="" method="post">
            <table>
                <tr>
                    <td>
                        <label for="uzivatel_jmeno">Uživatelské jméno</label>
                    </td>
                    <td>
                        <input type="text" name="uzivatel_jmeno">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="uzivatel_heslo">Heslo</label>
                    </td>
                    <td>
                        <input type="password" name="uzivatel_heslo">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="uzivatel_heslo_znovu">Opakovat heslo</label>
                    </td>
                    <td>
                        <input type="password" name="uzivatel_heslo_znovu">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" name="registrace">Registrovat</button>
                    </td>
                </tr>
            </table>
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
    <div class="footer footertext">
        <p>Portál společnosti Obchod, vytvořen 19.5.2021. Dnes je
            <?php date_default_timezone_set('Europe/Prague');
            echo date('d.m.Y G:i:s'); ?>
        </p>
    </div>
</body>

</html>