<?php


function update_user($email, $success)
{
    $link = connectdb();
    $id = getuserid($email);
    mysqli_begin_transaction($link);
    $statement = mysqli_stmt_init($link);
    if ($success) {
        mysqli_stmt_prepare($statement,
            "CALL anzahlanmeldungen_inc(?)");
        mysqli_stmt_bind_param($statement, 'i',
            $id);
        mysqli_stmt_execute($statement);
        mysqli_stmt_prepare($statement,
            "UPDATE benutzer 
                  SET letzteanmeldung=NOW()
                  WHERE email = (?);");
    } else {
        mysqli_stmt_prepare($statement,
            "CALL anzahlfehler_inc(?)");
        mysqli_stmt_bind_param($statement, 'i',
            $id);
        mysqli_stmt_execute($statement);
        mysqli_stmt_prepare($statement,
            "UPDATE benutzer 
                  SET letzterfehler=NOW()
                  WHERE email = (?);");
    }
    mysqli_stmt_bind_param($statement, 's',
        $email);
    mysqli_stmt_execute($statement);
    mysqli_commit($link);
    mysqli_close($link);
}

function checkemail($email)
{
    $link = connectdb();

    $statement = mysqli_stmt_init($link);
    mysqli_stmt_prepare($statement, "Select email from benutzer where email = (?)");
    mysqli_stmt_bind_param($statement, "s", $email);
    mysqli_stmt_execute($statement);
    $res = mysqli_stmt_get_result($statement);
    $row_count = mysqli_num_rows($res);


    mysqli_free_result($res);
    mysqli_close($link);
    return ($row_count > 0);
}
function getusername($email)
{
    $link = connectdb();

    $statement = mysqli_stmt_init($link);
    mysqli_stmt_prepare($statement, "Select name from benutzer where email = (?)");
    mysqli_stmt_bind_param($statement, "s", $email);
    mysqli_stmt_execute($statement);
    $res = mysqli_stmt_get_result($statement);
    $name = mysqli_fetch_all($res);

    mysqli_free_result($res);
    mysqli_close($link);

    return $name;
}
function getuserpasshash($email)
{
    $link = connectdb();

    $statement = mysqli_stmt_init($link);
    mysqli_stmt_prepare($statement, "Select passwort from benutzer where email = (?)");
    mysqli_stmt_bind_param($statement, "s", $email);
    mysqli_stmt_execute($statement);
    mysqli_stmt_bind_result($statement, $hashed_password); // Bindet das Ergebnis an eine Variable

    // Holen des Ergebnisses
    mysqli_stmt_fetch($statement);

    mysqli_stmt_close($statement);
    mysqli_close($link);

    return $hashed_password;
}
function getuserid($email)
{
    $link = connectdb();

    $statement = mysqli_stmt_init($link);
    mysqli_stmt_prepare($statement, "Select id from benutzer where email = (?)");
    mysqli_stmt_bind_param($statement, "s", $email);
    mysqli_stmt_execute($statement);
    $res = mysqli_stmt_get_result($statement);
    $id = mysqli_fetch_all($res);


    mysqli_free_result($res);
    mysqli_close($link);

    return $id;
}

function dbgetusernamebyid($id)
{
    $link = connectdb();

    $statement = mysqli_stmt_init($link);
    mysqli_stmt_prepare($statement, "Select name from benutzer where id = (?)");
    mysqli_stmt_bind_param($statement,"i",$id);
    mysqli_stmt_execute($statement);
    $res = mysqli_stmt_get_result($statement);
    $name = mysqli_fetch_all($res);


    mysqli_free_result($res);
    mysqli_close($link);

    return $name;
}
function isadmin($email)
{
    $link = connectdb();

    $statement = mysqli_stmt_init($link);
    mysqli_stmt_prepare($statement, "Select admin from benutzer where email = (?)");
    mysqli_stmt_bind_param($statement, "s", $email);
    mysqli_stmt_execute($statement);
    $res = mysqli_stmt_get_result($statement);
    $admin = mysqli_fetch_all($res);


    mysqli_free_result($res);
    mysqli_close($link);

    return $admin;
}
