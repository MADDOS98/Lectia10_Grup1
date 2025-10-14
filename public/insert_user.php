<?php
// Includeți conexiunea
require_once 'connection_procedural.php';

// Variabile pentru a stoca mesajele de răspuns
$message = '';
$message_type = ''; // success, error

// Variabile pentru a păstra datele introduse în formular
$username = '';
$email = '';
$age = '';

// Verificăm dacă cererea este de tip POST (adică formularul a fost trimis)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Preluarea și curățarea datelor din formular. Folosim htmlspecialchars() pentru XSS.
    $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $age = isset($_POST['age']) ? intval($_POST['age']) : 0; 
    
    // Validare de bază
    if (empty($username) || empty($email) || empty($age)) {
        $message = "Eroare: Toate câmpurile (Username, Email, Age) sunt obligatorii.";
        $message_type = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Eroare: Adresa de email nu este validă.";
        $message_type = 'error';
    } elseif ($age < 1 || $age > 120) {
        $message = "Eroare: Vârsta trebuie să fie o valoare între 1 și 120.";
        $message_type = 'error';
    } else {
        
        // Pregătirea interogării INSERT
        $sql = "INSERT INTO users (username, email, age) VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt === false) {
            $message = "Eroare la pregătirea interogării: " . mysqli_error($conn);
            $message_type = 'error';
        } else {
            // Legarea parametrilor: 'ssi' (string, string, integer)
            mysqli_stmt_bind_param($stmt, 'ssi', $username, $email, $age);

            // Executarea interogării
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $message = "Utilizator inserat cu succes! ID: " . mysqli_insert_id($conn) . " | Email: " . $email;
                $message_type = 'success';
                
                // Goliți câmpurile după succes
                $username = $email = $age = '';
            } else {
                $message = "Eroare la inserare (Cod: " . mysqli_errno($conn) . "): " . mysqli_error($conn);
                $message_type = 'error';
            }
            // Închiderea statement-ului
            mysqli_stmt_close($stmt);
        }
    }
}

// Închiderea conexiunii la sfârșitul scriptului
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Inserare Utilizator Simplificată - Procedural</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .message { padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        label { display: block; margin-top: 10px; }
        input[type="text"], input[type="email"], input[type="number"] { width: 300px; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 15px; margin-top: 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>

    <h2>Adăugare Utilizator Nou (Simplificat)</h2>
    
    <?php 
    // Afișarea mesajului de răspuns
    if (!empty($message)): 
    ?>
        <div class="message <?php echo $message_type; ?>">
            <?php echo $message; ?>
        </div>
    <?php 
    endif; 
    ?>

    <form method="POST" action="">
        
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required 
               value="<?php echo htmlspecialchars($username); ?>">
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required
               value="<?php echo htmlspecialchars($email); ?>">
        
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required min="1" max="120"
               value="<?php echo htmlspecialchars($age); ?>">
        
        <button type="submit" name="submit_user">Înregistrează Utilizatorul</button>
    </form>

</body>
</html>