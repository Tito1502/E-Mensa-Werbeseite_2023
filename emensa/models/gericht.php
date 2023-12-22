<?php
/**
 * Diese Datei enthält alle SQL Statements für die Tabelle "gerichte"
 */
function db_gericht_select_all() {
    try {
        $link = connectdb();

        $sql = 'SELECT id, name, beschreibung FROM gericht ORDER BY name';
        $result = mysqli_query($link, $sql);

        $data = mysqli_fetch_all($result, MYSQLI_BOTH);

        mysqli_close($link);
    }
    catch (Exception $ex) {
        $data = array(
            'id'=>'-1',
            'error'=>true,
            'name' => 'Datenbankfehler '.$ex->getCode(),
            'beschreibung' => $ex->getMessage());
    }
    finally {
        return $data;
    }

}

function db_gericht_sort_price_desc() {
    $link = connectdb();

    $sql = "SELECT name, preisintern FROM gericht WHERE preisintern > 2 ORDER BY name DESC;";
    $result = mysqli_query($link, $sql);

    $data = mysqli_fetch_all($result, MYSQLI_BOTH);

    mysqli_close($link);
    return $data;
}

function dbget5meals()
{
    $link = connectdb();
    if (!$link) {
        die('Verbindung zur Datenbank fehlgeschlagen: ' . mysqli_connect_error());
    }
    $sql = "select name, preisintern, preisextern, bildname from gericht order by name asc limit 5;";
    $data = mysqli_query($link, $sql);
    if (!$data) {
        die('Fehler bei der Abfrage: ' . mysqli_error($link));
    }

    //$result = mysqli_fetch_all($data, MYSQLI_ASSOC);

    //mysqli_free_result($data);
    mysqli_close($link);
    //return $result;
    return $data;
}
function dbget5mealswal()
{
    $link = connectdb();
    if (!$link) {
        die('Verbindung zur Datenbank fehlgeschlagen: ' . mysqli_connect_error());
    }
    $sql = "SELECT g.name ,g.preisintern, g.preisextern, g.bildname, GROUP_CONCAT(a.name SEPARATOR ', ') AS Allergene, GROUP_CONCAT(a.code SEPARATOR ', ') AS Code
        FROM gericht g
        LEFT JOIN gericht_hat_allergen ga ON g.id = ga.gericht_id
        LEFT JOIN allergen a ON ga.code = a.code
        GROUP BY g.name
        ORDER BY g.name
        LIMIT 5;";
    $data = mysqli_query($link, $sql);
    if (!$data) {
        die('Fehler bei der Abfrage: ' . mysqli_error($link));
    }
    //$result = mysqli_fetch_all($data, MYSQLI_ASSOC);

    //mysqli_free_result($data);
    mysqli_close($link);
    //return $result;
    return $data;
}
function dbget5mealsrand()
{
    $link = connectdb();
    if (!$link) {
        die('Verbindung zur Datenbank fehlgeschlagen: ' . mysqli_connect_error());
    }
    $sql = "select name, preisintern, preisextern, bildname from gericht order by rand() asc limit 5;";
    $data = mysqli_query($link, $sql);
    if (!$data) {
        die('Fehler bei der Abfrage: ' . mysqli_error($link));
    }

    //$result = mysqli_fetch_all($data, MYSQLI_ASSOC);

    //mysqli_free_result($data);
    mysqli_close($link);
    //return $result;
    return $data;
}
function dbget5mealsrandwal()
{
    $link = connectdb();
    if (!$link) {
    die('Verbindung zur Datenbank fehlgeschlagen: ' . mysqli_connect_error());
}
    $sql = "SELECT g.name ,g.preisintern, g.preisextern, g.bildname, GROUP_CONCAT(a.name SEPARATOR ', ') AS Allergene, GROUP_CONCAT(a.code SEPARATOR ', ') AS Code
        FROM gericht g
        LEFT JOIN gericht_hat_allergen ga ON g.id = ga.gericht_id
        LEFT JOIN allergen a ON ga.code = a.code
        GROUP BY g.name
        ORDER BY rand()
LIMIT 5;;";
    $data = mysqli_query($link, $sql);
    if (!$data) {
        die('Fehler bei der Abfrage: ' . mysqli_error($link));
    }

    //$result = mysqli_fetch_all($data, MYSQLI_ASSOC);

    //mysqli_free_result($data);
    mysqli_close($link);
    //return $result;
    return $data;
}

function dbgetmealcount()
{
    $link = connectdb();
    // MySQL-Abfrage: Anzahl der Datensätze in der Tabelle "gericht" zählen
    $sql = "SELECT count(*) as count FROM gericht";

    // Query ausführen
    $result = mysqli_query($link, $sql);

    // Überprüfen, ob die Abfrage erfolgreich war
    if (!$result) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }

    // Ergebnis abrufen und die Anzahl der Gerichte speichern
    $row = $result->fetch_assoc();
    $dishCount = $row['count'];

    // Ergebnis freigeben
    mysqli_free_result($result);
    return $dishCount;
}
