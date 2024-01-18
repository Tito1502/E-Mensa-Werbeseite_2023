<?php

function dbgetratings()
{
    $link = connectdb();
    if (!$link) {
        die('Verbindung zum Datenbankserver fehlgeschlagen: ' . mysqli_connect_error());
    }

    $ratings = array();

    $sql = "Select * from bewertungen order by bewertungszeitpunkt desc limit 30";
    $result = mysqli_query($link, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $ratings[] = $row;
        }

        mysqli_free_result($result);
    } else {
        die('Fehler bei der Abfrage: ' . mysqli_error($link));
    }

    mysqli_close($link);

    return $ratings;
}

function dbget30ratingswith_gid_uid()
{$link = connectdb();
    if (!$link) {
        die('Verbindung zum Datenbankserver fehlgeschlagen: ' . mysqli_connect_error());
    }

    $ratings = array();

    $sql = "SELECT bew.*, ben.name AS benutzer_name, ger.name AS gericht_name
        FROM bewertungen bew
        LEFT JOIN benutzer ben ON bew.benutzer_id = ben.id
        LEFT JOIN gericht ger ON bew.gericht_id = ger.id
        ORDER BY bew.bewertungszeitpunkt DESC
        LIMIT 30";
    $result = mysqli_query($link, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $ratings[] = $row;
        }

        mysqli_free_result($result);
    } else {
        die('Fehler bei der Abfrage: ' . mysqli_error($link));
    }

    mysqli_close($link);

    return $ratings;
}

function dbgetmyratingsall($id)
{


    $link = connectdb();
    if (!$link) {
        die('Verbindung zum Datenbankserver fehlgeschlagen: ' . mysqli_connect_error());
    }

    $names = array();

    $statement = mysqli_stmt_init($link);
    mysqli_stmt_prepare($statement, "SELECT bew.*, ger.name AS gericht_name
FROM bewertungen bew
LEFT JOIN gericht ger ON ger.id = bew.gericht_id
WHERE benutzer_id = ?
ORDER BY bew.bewertungszeitpunkt DESC;");
    mysqli_stmt_bind_param($statement,"i",$id);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);



    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $names[] = $row;
        }

        mysqli_free_result($result);
    } else {
        die('Fehler bei der Abfrage: ' . mysqli_error($link));
    }

    mysqli_close($link);

    return $names;
}