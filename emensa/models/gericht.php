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

function dbget5meals($israndom){
    $link = connectdb();

    if($israndom)$sql = "select name, preisintern, preisextern from gericht order by rand() asc limit 5";
    else $sql = "select name, preisintern, preisextern from gericht order by name asc limit 5;";
    $result = mysqli_query($link, $sql);

}
