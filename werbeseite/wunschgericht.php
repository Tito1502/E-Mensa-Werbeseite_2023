<html lang="de">
<head>
    <title>Wunschgericht</title>
    <meta charset="utf-8">
</head>
<body>
<?php
if($_POST!= [])
{
    $link = mysqli_connect(
        "localhost",
        "root",
        "0000",
        "emensawerbeseite",
        3306
    );
    if(!$link)
    {
        echo "Verbindung Fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }
    $gericht_name = $_POST["gericht_name"];
    $beschreibung = $_POST["beschreibung"];
    $gemeldet_von = $_POST["gemeldet_von"];
    $email =  $_POST["email"];

    // Prepared Statement für das Einfügen des Erstellers
    $stmt_ersteller = mysqli_stmt_init($link);
    mysqli_stmt_prepare($stmt_ersteller,"INSERT INTO ersteller (Name, Email) VALUES(?,?)");
    mysqli_stmt_bind_param($stmt_ersteller, "ss",$gemeldet_von, $email);


    if(mysqli_stmt_execute($stmt_ersteller))
    {
        $e_id = mysqli_insert_id($link);
        $stmt_wgericht = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt_wgericht,  "INSERT INTO wunschgericht (Name, Beschreibung, Erstellungsdatum, Ersteller_ID) VALUES(?,?,NOW(),?) ");
        mysqli_stmt_bind_param($stmt_wgericht, "sss",$gericht_name, $beschreibung, $e_id );

        header("Location: http://werbeseite/werbeseite.php");
        exit();

    }
    else
    {
        echo "Fehler beim Einfügen der Daten: " . mysqli_error($link);
    }
    mysqli_close($link);
}
?>
<form method="post">
    <label for="gname">Name des Gerichts:</label><br>
    <input type="text" id="gericht_name" name="gericht_name" required><br>
    <label for="beschreibung">Beschreibung des Gerichts:</label><br>
    <textarea rows="10" cols="20" id="beschreibung" name="beschreibung" required></textarea><br>
    <label for="gemeldet_von">Erstellername:</label><br>
    <input type="text" id="gemeldet_von" name="gemeldet_von"><br>
    <label for="mail">E-Mail:</label><br>
    <input type="email" id="email" name="email" required><br>
    <input type="submit" value="Wunsch abschicken"><br><br>
</form>

</body>
</html>