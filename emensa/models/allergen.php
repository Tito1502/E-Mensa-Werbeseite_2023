<?php
function dbgetallergenbycode($code)
{

    var_dump($code);
    $link = connectdb();
    if (!$link) {
        die('Verbindung zur Datenbank fehlgeschlagen: ' . mysqli_connect_error());
    }

    $code = implode(', ', $code);
    $code = trim($code);
    $code = explode(", ", $code);
    $code = "'" . implode("','", $code) . "'";
    $sql = "SELECT code, name FROM allergen WHERE code IN ($code);";
    $data = mysqli_query($link, $sql);

    if (!$data) {
        die('Fehler bei der Abfrage: ' . mysqli_error($link));
    }

    $result = mysqli_fetch_all($data, MYSQLI_ASSOC);

    mysqli_free_result($data);
    mysqli_close($link);
    return $result;
}