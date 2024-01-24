<?php

require_once ("../models/gericht.php");
require_once ("../models/allergen.php");
require_once ("../models/besucher.php");
require_once ("../models/newsletter_anmeldung.php");
require_once ("../models/benutzer.php");
require_once ("../models/bewertung.php");
require_once ("../models/bewertungen.php");
require_once('../models/bewertungEQ.php');
require_once('../models/gerichtEQ.php');

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

function add_gericht(): void
{
    $gericht = new gerichtEQ();
    $gericht->id = 50;
    $gericht->name = 'test';
    $gericht->beschreibung = "sfesdfsfs";
    $gericht->erfasst_am = "2020-08-25";
    $gericht->vegetarisch = "Yes";
    $gericht->vegen = "Nein";
    $gericht->preisintern = 5;
    $gericht->preisextern = 6.2;
    $gericht->save();
}

class WerbeseiteController
{
    public function index(RequestData $rq)
    {
        //add_gericht();

        $log = logger();
        $log->info('Hauptseite aufgerufen');
        session_start();
        if (!isset($_SESSION['login_ok'])){$_SESSION['login_ok'] = false;}
        $_SESSION['target'] = "";
        $_SESSION['login_result_message'] = null;

        //default:
        //$data = dbget5meals();
        $data = gerichtEQ::query()->limit(5)->get();
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

        $hr = dbselectallratingshighlighted();

        var_dump($_SESSION["userID"]);
        var_dump($_SESSION["user"]);
        var_dump($_SESSION["admin"]);


        return view
        ('homepage.homepage',
            ['meals' => $data,
                'show' => $show,
                'codes' => $acodes,
                'highlightedrating' => $hr,
                'newslettercount' => $nlcount,
                'mealcount'=> $mealcount,
                'visitorcount'=>$viscoutn]
        );
    }
    public function anmeldung()
    {
        session_start();
        $vars = ['msg' => $_SESSION['login_result_message']];
        return view('homepage.anmeldung', $vars);
    }

    public function anmeldung_verifizieren()
    {
        session_start();
        //var_dump($_POST);
        //check inputs
        $dbpass = getuserpasshash($_POST['email']);
        //var_dump(getuserpasshash($_POST['email']));

        if(checkemail($_POST['email']))
        {
            if(password_verify($_POST['pass'].'DbWt', $dbpass))
            {
                $_SESSION['login_ok'] = true;
                $_SESSION['user'] = $_POST['email'];
                $_SESSION['userID'] = getuserid($_POST['email']);
                $_SESSION['admin'] = isadmin($_POST['email']);

                update_user($_POST['email'], true);

                $log = logger();
                $log->info('Angemeldet ' . $_POST['email']);
                if($_SESSION["ratingattemptwologin"])
                {
                    $_SESSION["ratingattemptwologin"] = false;
                    header('Location: /bewertung');
                }
                else header('Location: /');
            }
            else
            {
                $log = logger();
                $log->warning('Passwort falsch ' . $_POST['email']);
                update_user($_POST['email'], false);
                $_SESSION['login_result_message'] = "Passwort falsch";
                header('Location: /anmeldung');
            }
        }
        else
        {
            $log = logger();
            $log->warning('Email existiert nicht ' . $_POST['email']);
            $_SESSION['login_result_message'] = "Email existiert nicht";
            header('Location: /anmeldung');
        }
    }

    public function abmeldung()
    {
        session_start();
        session_destroy();
        $log = logger();
        $log->info('Abgemeldet');
        header('Location: /');
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

    function bewertung(RequestData $rq)
    {
        session_start();

        $gerichtid = $rq->getGetData()['gerichtid'];
        $bildname = dbgetmealpicbyid($gerichtid);
        $gerichtname = dbgetmealbyid($gerichtid);
        if($_POST != NULL)
        {
            $_POST["benutzerID"] = $_SESSION["userID"];
            dbinsertrating($_POST);
            header("Location: /");
        }

        if(!$_SESSION["login_ok"])
        {
            if(!isset($_SESSION["ratingattemptwologin"]))$_SESSION["ratingattemptwologin"] = true;
            return view("homepage.anmeldung");
        }
        else return view("homepage.bewertung", ["bn"=>$bildname["bildname"], "gn"=> $gerichtname["name"], "gid"=> $gerichtid]);
    }

    function bewertungEQ(RequestData $rq)
    {
        session_start();

        $gerichtid = $rq->getGetData()['gerichtid'];
        $bildname = gerichtEQ::query()->find($gerichtid)->bildname;
        $gerichtname = gerichtEQ::query()->find($gerichtid)->name;
        if($_POST != NULL)
        {
            $_POST["benutzerID"] = $_SESSION["userID"];
            dbinsertrating($_POST);
            header("Location: /");
        }

        if(!$_SESSION["login_ok"])
        {
            if(!isset($_SESSION["ratingattemptwologin"]))$_SESSION["ratingattemptwologin"] = true;
            return view("homepage.anmeldung");
        }
        else return view("homepage.bewertung", ["bn"=>$bildname, "gn"=> $gerichtname, "gid"=> $gerichtid]);
    }


    function bewertungen(RequestData $rq)
    {

        //fertig
        session_start();
        $ratings2 = dbget30ratingswith_gid_uid();
        $isadmin = isadmin($_SESSION["user"]);
        $_SESSION["admin"] = $isadmin;

        if(isset($_GET['HL']))
        {
            $var = $rq->getGETData()['HL'];
            var_dump($var);
            highlight($rq->getGetData()['HL']);
            header('Location: /bewertungen');
        }
        return view("homepage.bewertungen",
            ['rs' => $ratings2]);
    }

    function bewertungenEQ(RequestData $rq)
    {
        session_start();
        $ratings2 = dbget30ratingswith_gid_uid();
        $isadmin = isadmin($_SESSION["user"]);
        $_SESSION["admin"] = $isadmin;
        if(isset($_GET['HL']))
        {
            $bewertung = BewertungEQ::query()->find($rq->getGetData()['HL']);
            if (BewertungEQ::query()->find($rq->getGetData()['HL'])->hervorheben)
            {
                $bewertung->hervorheben = 0;
                $bewertung->save();
            }
            else {
                $bewertung->hervorheben = 1;
                $bewertung->save();
            }

            header('Location: /bewertungen');
        }
        return view("homepage.bewertungen",
            ['rs' => $ratings2]);
    }


    function meinebewertungen()
    {
        session_start();
        $myratings = dbgetmyratingsall($_SESSION["userID"]);


        if($_POST != NULL)
        {
            dbdelratingbyid($_POST["delete_id"]);
            header("Location: /meinebewertungen");
        }

        return view("homepage.meinebewertungen",["myrts" => $myratings]);
    }

    function meinebewertungenEQ()
    {
        session_start();
        $myratings = dbgetmyratingsall($_SESSION["userID"]);


        if($_POST != NULL)
        {
            bewertungEQ::destroy($_POST["delete_id"]);
            //dbdelratingbyid($_POST["delete_id"]);
            header("Location: /meinebewertungen");
        }

        return view("homepage.meinebewertungen",["myrts" => $myratings]);
    }
}