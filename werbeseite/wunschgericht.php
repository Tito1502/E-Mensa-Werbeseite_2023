<!--
- Praktikum E-Mensa Werbeseite. Autoren:
- Jeremy, Mainka, 3567706
- Philip, Engels, 3569528
- Bol, Daudov, 3539110
-->

<!DOCTYPE html>
<html lang="de">

<head>
    <title>Wunschgericht</title>
    <meta charset="utf-8">
</head>

<body>

<?php

if ($_POST != [])
{
    //Verbindungsdaten
    $link = mysqli_connect
    (
        "localhost",
        "root",
        "root",
        "emensawerbeseite"
    );

    //wenn Verbindung fehl schlägt
    if (!$link)
    {
        echo "Verbindung fehlgeschlagen: ", mysqli_error($link);
        exit();
    }

    //wenn Formular abgeschickt wurde
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //überprüfen ob erwarteten Felder gefüllt sind
        if (isset($_POST["gericht_name"], $_POST["beschreibung"], $_POST["email"]))
        {
            $gericht_name = $_POST["gericht_name"];
            $beschreibung = $_POST["beschreibung"];
            $ersteller_name = empty($_POST["ersteller_name"]) ? "anonym" : $_POST["ersteller_name"];
            $email = $_POST["email"];

            //vorbereitete Anweisungen um SQL-Injektionen zu verhindern
            $sql_ersteller = "INSERT INTO ersteller (name, email) VALUES (?, ?)";
            $sql_wunschgericht = "INSERT INTO wunschgericht (name, beschreibung, email) VALUES (?, ?, ?)";

            //Beginn der Transaktion
            $link->begin_transaction();

            try
            {
                //Eintrag in ersteller
                $stmt_ersteller = $link->prepare($sql_ersteller);
                $stmt_ersteller->bind_param("ss", $ersteller_name, $email);
                $stmt_ersteller->execute();

                //Eintrag in wunschgericht
                $stmt_wunschgericht = $link->prepare($sql_wunschgericht);
                $stmt_wunschgericht->bind_param("sss", $gericht_name, $beschreibung, $email);
                $stmt_wunschgericht->execute();

                //Transaktion abschließen / Datenbankänderungen übernehmen
                $link->commit();
                echo "Wunsch erfolgreich eingetragen!";
            } catch (Exception $e) {
                //bei Fehler die Transaktion rückgängig machen
                $link->rollback();
                echo "Fehler beim Eintragen des Wunsches: " . $e->getMessage();
            }
        } else {
            echo "Ungültige Formulardaten.";
        }
    }

    mysqli_close($link);
}

?>

<h1>Wunschgericht</h1>

<!-- Formular -->
<form method="post">
    <label for="gericht_name">Name des Gerichts:</label><br>
    <input type="text" id="gericht_name" name="gericht_name" required><br>
    <label for="beschreibung">Beschreibung des Gerichts:</label><br>
    <textarea rows="10" cols="20" id="beschreibung" name="beschreibung" required></textarea><br>
    <label for="ersteller_name">Erstellername:</label><br>
    <input type="text" id="ersteller_name" name="ersteller_name"><br>
    <label for="email">E-Mail:</label><br>
    <input type="email" id="email" name="email" required><br>
    <input type="submit" value="Wunsch abschicken"><br><br>
</form>

</body>
</html>