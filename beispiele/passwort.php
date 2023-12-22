<?php
// Setze das gewählte Salt
$salt = 'DbWt';

// Das zu verschlüsselnde Passwort
$password = 'admin';

// Kombiniere Passwort und Salt
$passwort_mit_salt = $password . $salt;

// Hash das Passwort
$gehashtes_passwort = password_hash($passwort_mit_salt, PASSWORD_DEFAULT);

// Gib das gehashte Passwort aus
echo "Das gehashte Passwort mit Salt ist: " . $gehashtes_passwort;
?>
