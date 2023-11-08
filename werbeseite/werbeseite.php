<?php
// Überprüfen, ob ein POST-Request gesendet wurde
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Funktion zur Überprüfung der E-Mail-Domain
    function isAllowedDomain($email): bool
    {
        $notallowedDomains = ['rcpt.at','damnthespam.at', 'wegwerfmail.de', 'trashmail.de', 'trashmail.com'];
        $domain = explode('@', $email);
        return in_array($domain[1], $notallowedDomains);
    }

    // Daten aus dem Formular erhalten
    $name = trim($_POST['name']);
    $email = $_POST['email'];
    $sprache = $_POST['sprache'];
    $datenschutz = isset($_POST['datenschutz']);

    // Überprüfen, ob die Bedingungen erfüllt sind
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || isAllowedDomain($email) || !$datenschutz) {
        echo '<script>alert("Ihre E-Mail entspricht nicht den Vorgaben oder es wurden nicht alle erforderlichen Felder ausgefüllt.");</script>';
    } else {
        // Daten in einer Datei speichern
        $data = "$name, $email, $sprache\n";
        file_put_contents('newsletter_data.txt', $data, FILE_APPEND);

        // Erfolgsmeldung an den Benutzer ausgeben
        echo '<script>alert("Vielen Dank! Sie wurden erfolgreich für den Newsletter angemeldet.");</script>';
        echo '<script>window.location.href = "#newsletter";</script>';
    }
}
?>
<!DOCTYPE html>

<!--
- Praktikum E-Mensa Werbeseite. Autoren:
- Jeremy, Mainka, 3567706
- Philip, Engels, 3569528
-->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Werbeseite</title>
    <link rel="stylesheet" href="_CSS/style.css">

</head>
<body>
<nav>
    <div class="grid-container" id="mytopnav">
        <div class="grid-item logo"><a href="#logogroß"><img src="IMG/logo-studentenwerk.png" alt="Logo"></a></div>
        <div class="grid-item"><a href="#ankündigung">Ankündigung</a></div>
        <div class="grid-item"><a href="#speisen">Speisen</a></div>
        <div class="grid-item"><a href="#zahlen">Zahlen</a></div>
        <div class="grid-item"><a href="#newsletter">Newsletter</a></div>
        <div class="grid-item"><a href="#wichtig">Wichtig für uns</a></div>
    </div>
</nav>

<div class="main">

    <img id="logogroß" src="IMG/banner.jpg" alt="Logo">

    <div id="ankündigung">
        <h2>Bald gibt es Essen auch Online ;)</h2>

        <p style="border:2px solid #a0a0a0">
            Wir freuen uns, Ihnen mitteilen zu können, dass wir unser Angebot um
            eine köstliche Auswahl an Frühstücksoptionen erweitert haben. Beginnen
            Sie Ihren Tag mit frischen und energiereichen Speisen, die von unserem
            erfahrenen Team zubereitet werden. Von herzhaften Frühstücksburritos bis
            hin zu gesunden Müsli-Bowls - wir haben für jeden Geschmack etwas dabei.
            Kommen Sie vorbei und starten Sie Ihren Morgen bei uns in der Mensa!
        </p>
    </div>

    <div class="speisen">
        <h2 id="speisen">Köstlichkeiten, die Sie erwarten</h2>
        <table>
            <thead>
            <tr>
                <th></th>
                <th>Preis intern</th>
                <th>Preis extern</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Include the array.php file
            $meals = [];
            include 'array_gerichte.php';

            // Iterate through the $meals array and populate the table
            foreach ($meals as $key => $meal) {
                echo "<tr>";
                echo "<td>" . $meal['name'] . "</td>";
                echo "<td>" . $meal['preis_intern'] . "</td>";
                echo "<td>" . $meal['preis_extern'] . "</td>";
                echo "<td><img src='" . $meal['bild'] . "' alt='Bild'></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>




    <div>
        <h2 id="zahlen">E-Mensa in Zahlen</h2>
        <div class="platzhalter">
            <input placeholder="X" disabled> Besuche
            <input placeholder="Y" disabled> Anmeldungen zum Newsletter
            <input placeholder="Z" disabled> Speisen
        </div>
    </div>

    <div class="newsletter">
        <h2 id="newsletter">Interesse geweckt? Wir informieren Sie!</h2>
        <form method="POST" action="werbeseite.php">
            <div class="newsletter-grid">
                <div class="textfelder">
                    <div>
                        <label for="name">Ihr Name:</label><br>
                        <input type="text" name="name" id="name" placeholder="Vorname" required><br><br>
                    </div>
                    <div>
                        <label for="email">Ihre E-Mail:</label><br>
                        <input type="email" name="email" id="email" required><br><br>
                    </div>
                </div>

                <div class="sprache">
                    <label for="sprache">Newsletter bitte in: </label><br>
                    <select name="sprache" id="sprache">
                        <option value="Deutsch" selected>Deutsch</option>
                        <option value="Englisch">Englisch</option>
                    </select><br><br>
                </div>

                <div class="datenschutz">
                    <input type="checkbox" name="datenschutz" id="datenschutz" required>
                    <label for="datenschutz">Den Datenschutzbestimmungen stimme ich zu</label><br><br>
                </div>

                <input type="submit" value="Zum Newsletter anmelden" class="submit">
            </div>
        </form>
    </div>



    <div class="listewichtig">
        <h2 id="wichtig">Das ist uns wichtig</h2>
        <ul class="liste">
            <li>Beste frische saisonale Zutaten</li>
            <li>Ausgewogene abwechslungsreiche Gerichte</li>
            <li>Sauberkeit</li>
        </ul>
    </div>

    <h2 id="abschied">Wir freuen uns auf Ihren Besuch!</h2>



</div>

<hr>

<footer id="impressum" style="text-align:center;">
    (c)E-Mensa Gmbh | Jeremy Mainka, Philip Engels | <a href="#impressum">Impressum</a>
</footer>

</body>
</html>