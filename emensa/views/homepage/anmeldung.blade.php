@extends('layouts.emensalayout')

<!--
- Praktikum E-Mensa Werbeseite. Autoren:
- Jeremy, Mainka, 3567706
- Philip, Engels, 3569528
- Bol, Daudov, 3539110
-->

@section('title', 'Ihre E-Mensa')

@section('main')
    <?php echo $_SESSION['login_result_message'];?>
    <form action="/anmeldung_verifizieren" method="POST">
        <label for="user">Email:</label><br>
        <input type="text" id="email" name="email" required><br>
        <label for="pass">Passwort:</label><br>
        <input type="password" id="pass" name="pass" required><br>
        <input type="submit" value="Anmeldung"><br><br>
    </form>
@endsection
