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
    $sql = "select id,name, preisintern, preisextern, bildname from gericht order by name asc limit 5;";
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
    $sql = "SELECT g.id,g.name ,g.preisintern, g.preisextern, g.bildname, GROUP_CONCAT(a.name SEPARATOR ', ') AS Allergene, GROUP_CONCAT(a.code SEPARATOR ', ') AS Code
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
    $sql = "select id, name, preisintern, preisextern, bildname from gericht order by rand() asc limit 5;";
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
    $sql = "SELECT g.id, g.name ,g.preisintern, g.preisextern, g.bildname, GROUP_CONCAT(a.name SEPARATOR ', ') AS Allergene, GROUP_CONCAT(a.code SEPARATOR ', ') AS Code
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

function dbgetmealbyid($id)
{
    $link = connectdb();

    $statement = mysqli_stmt_init($link);
    mysqli_stmt_prepare($statement, "Select name from gericht where id = (?)");
    mysqli_stmt_bind_param($statement,"i",$id);
    mysqli_stmt_execute($statement);
    $res = mysqli_stmt_get_result($statement);
    $name = mysqli_fetch_assoc($res);


    mysqli_free_result($res);
    mysqli_close($link);

    return $name;
}
function dbgetmealpicbyid($id)
{
    $link = connectdb();

    $statement = mysqli_stmt_init($link);
    mysqli_stmt_prepare($statement, "Select bildname from gericht where id = (?)");
    mysqli_stmt_bind_param($statement,"i",$id);
    mysqli_stmt_execute($statement);
    $res = mysqli_stmt_get_result($statement);
    $bildname = mysqli_fetch_assoc($res);


    mysqli_free_result($res);
    mysqli_close($link);

    return $bildname;
}
