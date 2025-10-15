<?php
    // Includeți conexiunea
    require_once 'connection_procedural.php';

    // Exemplu de email cautat cu wildacard '%' inseamna orice sir de caractere, wildcard-urile sunt folosite in SQL pentru a inlocui orice sir de caractere
    // Implicit cautam toate emailurile care contin '@gmail'
    $searchTerm = '%@%';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
        // Preluarea termenului de căutare din formular
        $input = trim($_POST['search'], "\s%"); // Curățare și eliminare wildcard-uri existente
        $input = preg_replace('/[^a-zA-Z0-9\.@]/', '', $input); // Eliminare caractere speciale
        $input = mysqli_real_escape_string($conn, $input); // Securizarea împotriva SQL Injection
        // Adăugarea wildcard-urilor pentru LIKE
        $searchTerm = '%' . $input . '%';
    }

    // Folosirea mysqli_prepare() (pregatirea interogarii catre baza de date)
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email LIKE ?");

    // Verificam daca pregatirea este
    if ($stmt === false) {
        die("Eroare la pregătirea interogării: " . mysqli_error($conn));
    }

    // Folosirea mysqli_stmt_bind_param() pentru a introduce date reale in loc de "?"
    // 's' = string, indicând tipul de date al variabilei $searchTerm
    // Securizarea împotriva SQL Injection
    mysqli_stmt_bind_param($stmt, 's', $searchTerm);

    // 2. Executarea interogarii mysqli_stmt_execute()
    $result = mysqli_stmt_execute($stmt);

    // Verificam daca am obtinut rezultatul
    if ($result === false) {
        die("Eroare la executarea interogării: " . mysqli_stmt_error($stmt));
    }


    // Obținerea rezultatului interogării
    $res = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Lista Utilizatori - Procedural</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 60%;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .no-results {
            text-align: center;
            font-style: italic;
            color: #888;
        }
    </style>
</head>

<body>

    <form action="" method="post">
        <label for="search">Caută email (LIKE):</label>
        <input type="text" id="search" name="search" placeholder="@gmail">
        <button type="submit">Caută</button>
    </form>

    <h2>Utilizatori cu email LIKE '<?php echo htmlspecialchars($searchTerm); ?>' (Procedural)</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Age</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($res) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($res)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']); ?></td>
                        <td><?= htmlspecialchars($row['username']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['age']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="no-results">Nu s-au găsit utilizatori.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php
        // Eliberarea memoriei și închiderea statement-ului și a conexiunii
        mysqli_free_result($res);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    ?>

</body>
</html>