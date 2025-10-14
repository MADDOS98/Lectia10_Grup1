<?php

require_once '../config.php'; 

// Conexiunea la baza de date folosind mysqli_connect()
$conn = mysqli_connect($host, $user, $pass, $db_name);

// Verificarea erorii de conexiune cu mysqli_connect_errno()
if (mysqli_connect_errno()) {
    // Afisarea unui mesaj controlat la eroare
    die("Eroare de conectare la baza de date: " . mysqli_connect_error() . 
        " (Cod: " . mysqli_connect_errno() . ")");
}

// Schimbarea charset cu mysqli_set_charset()
mysqli_set_charset($conn, 'utf8mb4');