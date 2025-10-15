<?php

// Dezactivarea rapoartelor de erori MySQLi pentru a prelua controlul erorilor manual cu mysqli_connect_errno() si mysqli_connect_error()
mysqli_report(MYSQLI_REPORT_OFF);

// Includerea fisierului de configurare
require_once '../config.php'; 

// Conexiunea la baza de date folosind mysqli_connect() care face legatura la serverul MySQL
$conn = mysqli_connect($host, $user, $pass, $db_name);

// Verificarea erorii de conexiune cu mysqli_connect_errno() care returneaza codul erorii
if (mysqli_connect_errno()) {
    // Terminarea scriptului cu un mesaj de eroare
    die("Eroare de conectare la baza de date: " . mysqli_connect_error() . // Mesajul erorii
        " (Cod: " . mysqli_connect_errno() . ")"); // Codul erorii
}

// Schimbarea charset cu mysqli_set_charset() pentru a evita probleme cu diacriticele
mysqli_set_charset($conn, 'utf8mb4');