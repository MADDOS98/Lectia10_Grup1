<?php
/**
 * Script PHP procedural pentru gestionarea bazei de date "group_users".
 * Conectează, verifică existența DB, o creează (dacă nu există) împreună cu tabelul "users".
 */

// 1. Includerea fisierului de configurare
mysqli_report(MYSQLI_REPORT_OFF); 

require_once 'config.php';

// 2. Conectarea la serverul MySQL
$conn = mysqli_connect($host, $user, $pass);

// Verifică conexiunea
if (!$conn) {
    die("Eșec la conectare: " . mysqli_connect_error());
}

// 3. Verifică existența bazei de date
$db_check_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'";
$result = mysqli_query($conn, $db_check_query);

if (mysqli_num_rows($result) > 0) {
    // Baza de date există
    echo "Baza de date '$db_name' există deja.<br>";

    // Schimbă baza de date activă
    mysqli_select_db($conn, $db_name);
    
    // Interogare pentru a vedea tabelele
    $tables_query = "SHOW TABLES";
    $tables_result = mysqli_query($conn, $tables_query);

    if (mysqli_num_rows($tables_result) > 0) {
        echo "Tabelele existente în '$db_name':<br>";
        while ($row = mysqli_fetch_array($tables_result)) {
            echo "- " . $row[0] . "<br>";
        }
    } else {
        echo "Baza de date '$db_name' nu conține încă niciun tabel.";
    }

} else {
    // Baza de date nu există, o creăm
    $sql_create_db = "CREATE DATABASE $db_name";
    if (mysqli_query($conn, $sql_create_db)) {
        echo "Baza de date '$db_name' a fost creată cu succes!<br>";

        // 4. Conectarea la noua bază de date
        mysqli_select_db($conn, $db_name);

        // 5. Creăm tabelul "users"
        $sql_create_table = "
            CREATE TABLE users (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(70) NOT NULL,
                email VARCHAR(120) NOT NULL UNIQUE,
                age INT(3) UNSIGNED
            )
        ";

        if (mysqli_query($conn, $sql_create_table)) {
            echo "Tabelul 'users' a fost creat cu succes în '$db_name'.<br>";
        } else {
            echo "Eșec la crearea tabelului: " . mysqli_error($conn);
        }

    } else {
        echo "Eșec la crearea bazei de date: " . mysqli_error($conn);
    }
}

// 6. Închide conexiunea
mysqli_close($conn);
?>
