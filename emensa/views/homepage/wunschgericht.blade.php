<html lang="de">
<head>
    <title>Wunschgericht</title>
    <meta charset="utf-8">
</head>
<body>
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