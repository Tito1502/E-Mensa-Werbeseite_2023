
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
    <style>
        /* ... */

        .main {
            width: fit-content;
            margin: 0 auto 0 auto;
        }



        /* Navbar */
        body {
            margin: 0;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto auto auto auto;
            grid-gap: 10px;
            background-color: black;
            text-align: center;
            width: 100%;

        }

        .grid-container a{
            text-decoration: none;
            color: white;
        }

        .grid-item{
            padding: 10px;
        }

        /* Ankündigung */

        #ankündigung p{
            max-width: 600px;
        }

        #ankündigung
        {
            width: fit-content;
            margin-bottom: 50px;
        }

        /* Speisen */

        .speisen {
            width: fit-content;
            margin: 0 auto 50px auto;
        }

        table,td, th{
            border: thin solid #a0a0a0;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            border-width: thin 0 0 thin;

        }


        th, td {
            font-size: larger;
            font-weight: normal;
            text-align: center;
        }


        td:first-child {
            text-align: left;
            max-width: 400px;
        }

        th {
            background-color: #f1f3f4;
            font-weight: 700;
        }

        /*Platzhalter für Zahlen*/
        .platzhalter {
            width: fit-content;
            margin: 0 auto 50px auto;
        }
        .platzhalter input {
            width: 8px;
        }

        /* Newsletter */

        .newsletter-grid {
            display: grid;
            grid-template-columns: auto auto;
            width: fit-content;
            margin-bottom: 50px;
        }

        .textfelder {
            display: flex;
            width: fit-content;
        }

        .textfelder div{
            margin-right: 15px;
        }

        .textfelder input {
            width: 120px;
        }



        .datenschutz {
            margin-right: 15px;
        }

        .submit {
            height: fit-content;
        }

        /* Liste */
        .liste
        {
            width: fit-content;
            margin: 0 auto 50px auto;
        }

        /* Abschied */
        #abschied
        {
            text-align: center;
        }

        h2 #abschied
        {
            text-indent: 0;
            width: fit-content;
        }


    </style>

</head>
<body>
<nav>
    <div class="grid-container" id="mytopnav">
        <div class="grid-item"><a href="#logogroß"><img src="" alt="Logo"></a></div>
        <div class="grid-item"><a href="#ankündigung">Ankündigung</a></div>
        <div class="grid-item"><a href="#speisen">Speisen</a></div>
        <div class="grid-item"><a href="#zahlen">Zahlen</a></div>
        <div class="grid-item"><a href="#kontakt">Kontakt</a></div>
        <div class="grid-item"><a href="#wichtig">Wichtig für uns</a></div>
    </div>
</nav>

<div class="main">

    <img id="logogroß" src="" alt="Logo">

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
            <tr>
                <td>Rindfleisch mit Bambus, Kaiserschoten und roter Paprika, dazu Mie Nudeln</td>
                <td>3,50</td>
                <td>6,20</td>
            </tr>
            <tr>
                <td>Spinatrisotto mit kleinen Samosateigecken und gemischter Salat</td>
                <td>2,90</td>
                <td>5,30</td>
            </tr>
            <tr>
                <td>...</td>
                <td>...</td>
                <td>...</td>
            </tr>
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
        <h2 id="kontakt">Interesse geweckt? Wir informieren Sie!</h2>
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

            <input type="submit" value="Zum Newsletter anmelden" class="submit" disabled>
        </div>
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