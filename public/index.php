<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Meniu Principal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column; /* Aranjează elementele pe verticală */
            align-items: center; /* Centrează orizontal */
            margin-top: 50px;
        }
        .buton-link {
            display: block; /* Face linkul să ocupe toată lățimea disponibilă pe rândul său */
            width: 250px; /* Lățimea fixă pentru butoane */
            padding: 10px 15px;
            margin-bottom: 10px; /* Spațiu sub fiecare buton */
            text-align: center;
            text-decoration: none; /* Elimină sublinierea standard a linkurilor */
            color: white; /* Text alb */
            background-color: #007bff; /* Culoare de fundal albastru */
            border: 1px solid #0056b3; /* Ramă mai închisă */
            border-radius: 5px; /* Colțuri rotunjite */
            transition: background-color 0.3s ease; /* Tranziție lină la hover */
        }

        .buton-link:hover {
            background-color: #0056b3; /* Culoare de fundal mai închisă la trecerea mouse-ului */
        }
    </style>
</head>
<body>
  
    <a href="connection_procedural.php" class="buton-link">Verifica conexiunea (connection_procedural.php)</a>
    <a href="select_users.php" class="buton-link">Selecteaza utilizatorii (select_users.php)</a>
    <a href="insert_user.php" class="buton-link">Adauga utilizatori (insert_user.php)</a>
  
</body>
</html>
