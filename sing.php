<?php
$con = mysqli_connect('localhost:8889', 'root', 'root', 'ghid_turistic');

// Verifică conexiunea
if (!$con) {
    die("Conexiunea a eșuat: " . mysqli_connect_error());
}

// Variabile pentru mesaje
$mesaj = "";
$stil = "";

// Procesare formular
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $parola = password_hash(htmlspecialchars($_POST['parola']), PASSWORD_DEFAULT); // Criptare parolă

    // Verifică dacă username-ul există deja
    $check_query = "SELECT * FROM users WHERE username = ?";
    $stmt = $con->prepare($check_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $mesaj = "Utilizatorul <strong>$username</strong> există deja. Alege un alt nume de utilizator.";
        $stil = "background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;";
    } else {
        $insert_query = "INSERT INTO users (username, parola) VALUES (?, ?)";
        $stmt_insert = $con->prepare($insert_query);
        $stmt_insert->bind_param("ss", $username, $parola);

        if ($stmt_insert->execute()) {
            $mesaj = "Mulțumim, <strong>$username</strong>! Contul tău a fost creat cu succes.";
            $stil = "background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;";
        } else {
            $mesaj = "Eroare la trimiterea formularului: " . $stmt_insert->error;
            $stil = "background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;";
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Conectare</title>
    <link rel="stylesheet" type="text/css" href="sing.css">
</head>
<body>
    <div class="sidebar">
        <a href="homepage.html">Înapoi</a>
    </div>

    <div class="auth">
        <h1 style="color: #2c3e50;">Înregistrare</h1>

        <?php if ($mesaj): ?>
            <div style="width: 60%; margin: 20px auto; padding: 15px; border-radius: 8px; text-align: center; font-family: Arial, sans-serif; <?= $stil ?>">
                <?= $mesaj ?>
            </div>
        <?php endif; ?>

        <form name="authForm" method="POST" action="sing.php">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Parola</label>
                <input type="password" name="parola" class="form-control" required>
            </div>
            <div class="wrapper">
                <button type="submit" class="btn btn-primary" name="login">Înregistrează-te</button>
            </div>
        </form>
    </div>
</body>
</html>
