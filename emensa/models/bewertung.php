<?php

function dbinsertrating($bewertung)
{
    $link = connectdb();
    if (!$link) {
    die('Verbindung zum Datenbankserver fehlgeschlagen: ' . mysqli_connect_error());
}
    $scc = false;
    echo "dump bewertung <br>";
    var_dump($bewertung);
    $statement = mysqli_stmt_init($link);
    if ($statement) {
        $sql = "INSERT INTO bewertungen (sternbewertung, bemerkung, gericht_id,benutzer_id) VALUES (?, ?, ?, ?)";

        // Prepared Statement vorbereiten
        mysqli_stmt_prepare($statement, $sql);

        // Binden der Parameter
        mysqli_stmt_bind_param($statement, "ssii", $bewertung["sternbewertung"], $bewertung["bemerkung"], $bewertung["gerichtID"], $bewertung["benutzerID"]);

        // Ausführen des Statements
        mysqli_stmt_execute($statement);

        // Prepared Statement schließen
        mysqli_stmt_close($statement);
    } else {
        die('Fehler beim Initialisieren des Statements: ' . mysqli_error($link));
    }
    mysqli_close($link);
}

function dbdelratingbyid($id)
{
    $link = connectdb();

    $statement = mysqli_stmt_init($link);
    mysqli_stmt_prepare($statement, "DELETE FROM bewertungen WHERE id = ?");
    mysqli_stmt_bind_param($statement, "i", $id);
    mysqli_stmt_execute($statement);

    mysqli_close($link);
}