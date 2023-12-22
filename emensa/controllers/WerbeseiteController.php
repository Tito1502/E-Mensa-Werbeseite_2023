<?php

require_once ("../models/gericht.php");
require_once ("../models/allergen.php");
require_once ("../models/besucher.php");
require_once ("../models/newsletter_anmeldung.php");
require_once ("../models/benutzer.php");

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

function logger(): Logger
{
    // Create a log channel
    $log = new Logger('name');
    $log->pushHandler(new StreamHandler(dirname(__DIR__). '/storage/logs/app.log', Level::Info));

    return $log;
}
class WerbeseiteController
{
    public function index(RequestData $rq)
    {
        session_start();
        if (!isset($_SESSION['login_ok'])){$_SESSION['login_ok'] = false;}
        $_SESSION['target'] = "";
        $_SESSION['login_result_message'] = null;
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

                $gericht_name_neu = htmlspecialchars($gericht_name);
                $beschreibung_neu = htmlspecialchars($beschreibung);
                $ersteller_name_neu = htmlspecialchars($ersteller_name);
                $email_neu = htmlspecialchars($email);

                //vorbereitete Anweisungen um SQL-Injektionen zu verhindern
                $sql_ersteller = "INSERT INTO ersteller (name, email) VALUES (?, ?)";
                $sql_wunschgericht = "INSERT INTO wunschgericht (name, beschreibung, email) VALUES (?, ?, ?)";

                //Beginn der Transaktion
                $link->begin_transaction();

                try
                {
                    //Eintrag in ersteller
                    $stmt_ersteller = $link->prepare($sql_ersteller);
                    $stmt_ersteller->bind_param("ss", $ersteller_name_neu, $email_neu);
                    $stmt_ersteller->execute();

                    //Eintrag in wunschgericht
                    $stmt_wunschgericht = $link->prepare($sql_wunschgericht);
                    $stmt_wunschgericht->bind_param("sss", $gericht_name_neu, $beschreibung_neu, $email_neu);
                    $stmt_wunschgericht->execute();

                    //Transaktion abschließen / Datenbankänderungen übernehmen
                    $link->commit();
                    echo "Wunsch erfolgreich eingetragen!";
                    header("Location: /");
                    exit();
                } catch (Exception $e) {
                    //bei Fehler die Transaktion rückgängig machen
                    $link->rollback();
                    echo "Fehler beim Eintragen des Wunsches: " . $e->getMessage();
                }
            } else {
                echo "Ungültige Formulardaten.";
            }
        }
        return view("homepage.wunschgericht");
    }

}