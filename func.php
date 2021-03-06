<?php

function optionFromSql($sqlResult, $value, $text)
{
    $result = "";
    while ($row = $sqlResult->fetch_assoc()) {
        $result .= "<option value=\"" . $row["$value"] . "\">";
        foreach ($text as $key => $hodnota) {
            $result .= $row["$hodnota"] . " ";
        }
        $result .= "</option>";
    }
    return $result;
}

function TableFrom2DArray($HeaderArray, $l2Arr)
{
    $result  = "<table class=\"generatedtable\">";
    $result .= "<thead>";
    $result .= "<tr>";
    $result .= WrapL1ArrInTableData($HeaderArray);
    $result .= "</tr>";
    $result .= "</thead>";
    $result .= "<tbody>";
    $result .= WrapL2ArrInTableRow($l2Arr);
    $result .= "</tbody>";
    $result .= "</table>";

    return $result;
}
function WrapL2ArrInTableRow($l2Arr)
{
    $result = "";
    foreach ($l2Arr as $key => $l1Arr) {
        $result .= "<tr>" . WrapL1ArrInTableData($l1Arr) . "</tr>";
    }
    return $result;
}
function WrapL1ArrInTableData($l1Arr)
{
    $result = "";
    foreach ($l1Arr as $key => $value) {
        $result .= "<td>" . $value . "</td>";
    }
    return $result;
}

function newQuery($connection, $query, $ifSucceed = "", $ifFailed = __LINE__)
{
    if ($connection->query($query) === TRUE) {
        echo "Query was successfully executed - $ifSucceed";
    } else {
        echo "Error: " . $query . "<br>" . $connection->error . "<br> ->" . $ifFailed;
    }
}

function login($connection, $username, $password) // todo změnit 'crypto_uzivatel' a 'jmeno_uzivatel' v sql dotazu
{
    $sql = "SELECT crypto_uzivatel
            FROM uzivatele
            WHERE jmeno_uzivatel = '$username'";
    $result = $connection->query($sql);
    $result = mysqli_fetch_all($result, MYSQLI_NUM);
    $hash = hash("sha384", $password);
    if ($result[0][0] === $hash) {
        echo "nyní jste přihlášeni";
        return true;
    } else {
        echo "špatně zadané jméno nebo heslo, zkuste to prosím znovu nebo se zaregistrujte: <a href=\"registrace.php\">registrace</a>";
        return false;
    }
}
function TableFrom2DArrayCustom1($HeaderArray, $l2Arr, $kody)
{
    $result  = "<table class=\"generatedtable\">";
    $result .= "<thead>";
    $result .= "<tr>";
    $result .= WrapL1ArrInTableData($HeaderArray);
    $result .= "<td>přidat do košíku</td>";
    $result .= "<td>V košíku</td>";
    $result .= "</tr>";
    $result .= "</thead>";
    $result .= "<tbody>";
    $result .= WrapL2ArrInTableRowCustom1($l2Arr, $kody);
    $result .= "</tbody>";
    $result .= "</table>";

    return $result;
}
function WrapL2ArrInTableRowCustom1($l2Arr, $kody)
{
    $result = "";
    foreach ($l2Arr as $key => $l1Arr) {
        $result .= "<tr>" . WrapL1ArrInTableDataCustom1($l1Arr, $kody, $key) . "<td><button type=\"button\" onclick=\"addToCart($kody[$key])\" class=\"btn btn-secondary\" id=\"kup-$kody[$key]\">do košíku</button></td><td><span id=\"kosik-$kody[$key]\" class=\"col-1\">0</span></td></tr>";
    }
    return $result;
}
function WrapL1ArrInTableDataCustom1($l1Arr, $kody, $currKey)
{
    $result = "";
    foreach ($l1Arr as $key => $value) {
        if ($key == "sklad") {
            $result .= "<td id=\"sklad-$kody[$currKey]\">" . $value . "</td>";
        } else {
            $result .= "<td>" . $value . "</td>";
        }
    }
    return $result;
}
function pushKody($result)
{
    $kody = [];
    while ($row = $result->fetch_row()) {
        array_push($kody, $row[1]);
    }
    return $kody;
}
