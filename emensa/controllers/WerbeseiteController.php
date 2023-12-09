<?php

require_once ("../models/gericht.php");
require_once ("../models/allergen.php");
require_once ("../models/besucher.php");
require_once ("../models/newsletter_anmeldung.php");
class WerbeseiteController
{
    public function index(RequestData $rq)
    {
        //default:
        $data = dbget5meals();
        $show = false;
        //else
        $isRandom = $rq->getGetData()['israndom'] ?? null;
        $isShow = $rq->getGetData()['show'] ?? null;
        if($isRandom=== 'true' && $isShow === 'true') {$data = dbget5mealsrandwal(); $show = true;}
        if($isRandom === 'true' && $isShow === 'false') {$data = dbget5mealsrand(); $show = false;}
        if($isRandom === 'false' && $isShow === 'true') {$data = dbget5mealswal(); $show = true;}
        $acodes = null;
        if($show)
        {
            while ($row = mysqli_fetch_assoc($data))
                if($row['Code'] != null)$codes[] = $row['Code'];
            //var_dump($codes);
            $acodes = dbgetallergenbycode($codes);
        }

        $nlcount = dbgetnlsubcount();
        $mealcount = dbgetmealcount();
        $viscoutn = dbcountvisitorbydate($date= date('Y-m-d'));


        $link = connectdb();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Funktion zur Überprüfung der E-Mail-Domain
            function isnotAllowedDomain($email): bool
            {
                $notallowedDomains = ['rcpt.at','damnthespam.at', 'wegwerfmail.de', 'trashmail.de', 'trashmail.com'];
                $domain = explode('@', $email);
                return in_array(strtolower($domain[1]), $notallowedDomains);
            }

            // Daten aus dem Formular erhalten
            $name = trim($_POST['name']);
            $email = $_POST['email'];
            $sprache = $_POST['sprache'];
            $datenschutz = isset($_POST['datenschutz']);

            // Überprüfen, ob die Bedingungen erfüllt sind
            if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || isnotAllowedDomain($email) || !$datenschutz) {
                echo '<script>alert("Ihre E-Mail entspricht nicht den Vorgaben oder es wurden nicht alle erforderlichen Felder ausgefüllt.");</script>';
            } else {
                $result = mysqli_query($link, "SELECT * FROM newsletter_anmeldung WHERE email = '$email'");

                if (!$result) {
                    echo "Fehler während der Abfrage:  ", mysqli_error($link);
                    exit();
                }

                if (mysqli_num_rows($result) == 0)
                    $result = mysqli_query($link, "INSERT INTO newsletter_anmeldung (email, name, language) VALUES ('$email','$name','$sprache')");
                else
                    $result = mysqli_query($link, "UPDATE newsletter_anmeldung SET name='$name', language='$sprache'  WHERE email ='$email'");

                // Erfolgsmeldung an den Benutzer ausgeben
                echo '<script>alert("Vielen Dank! Sie wurden erfolgreich für den Newsletter angemeldet.");</script>';
                echo '<script>window.location.replace("/");</script>';
                exit;
            }
        }

        return view
        ('homepage.homepage',
            ['meals' => $data,
                'show' => $show,
                'codes' => $acodes,
                'newslettercount' => $nlcount,
                'mealcount'=> $mealcount,
                'visitorcount'=>$viscoutn]
        );
    }

    public function wunschgericht(RequestData $rq)
    {
        $link  =connectdb();
        if ($_POST != []) {

            $gericht_name = $_POST["gericht_name"];
            $beschreibung = $_POST["beschreibung"];
            $gemeldet_von = $_POST["gemeldet_von"];
            $email = $_POST["email"];

            // Prepared Statement für das Einfügen des Erstellers
            $stmt_ersteller = mysqli_stmt_init($link);
            mysqli_stmt_prepare($stmt_ersteller, "INSERT INTO ersteller (Name, Email) VALUES(?,?)");
            mysqli_stmt_bind_param($stmt_ersteller, "ss", $gemeldet_von, $email);


            if (mysqli_stmt_execute($stmt_ersteller)) {
                $e_id = mysqli_insert_id($link);
                $stmt_wgericht = mysqli_stmt_init($link);
                mysqli_stmt_prepare($stmt_wgericht, "INSERT INTO wunschgericht (Name, Beschreibung, Erstellungsdatum, Ersteller_ID) VALUES(?,?,NOW(),?) ");
                mysqli_stmt_bind_param($stmt_wgericht, "sss", $gericht_name, $beschreibung, $e_id);
                mysqli_stmt_execute($stmt_wgericht);

                header("Location: /");
                exit();

            } else {
                echo "Fehler beim Einfügen der Daten: " . mysqli_error($link);
            }
        }
        return view("homepage.wunschgericht");
    }

}