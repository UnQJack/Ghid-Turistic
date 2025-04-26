<?php
$con = mysqli_connect('localhost:8889', 'root', 'root', 'ghid_turistic');

// Verificare conexiune
if (!$con) {
    die("Conexiunea a eșuat: " . mysqli_connect_error());
}

$mesaj = "";
$stil = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $parola = $_POST['parola'];

    // Caută utilizatorul în baza de date
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verifică parola
        if (password_verify($parola, $user['parola'])) {
            $mesaj = "Autentificare reușită. Bine ai venit, <strong>$username</strong>!";
            $stil = "background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;";
        } else {
            $mesaj = "Parolă incorectă!";
            $stil = "background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;";
        }
    } else {
        $mesaj = "Utilizatorul nu există!";
        $stil = "background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;";
    }

    $stmt->close();
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Autentificare</title>
	<link rel="stylesheet" type="text/css" href="auth.css">
</head>
<body>
    <div class="sidebar">
        <a href="homepage.html">Înapoi</a>
    </div>

	<div class="auth">
		<h1 style="color: #2c3e50;">Autentificare</h1>

        <?php if ($mesaj): ?>
            <div style="width: 60%; margin: 20px auto; padding: 15px; border-radius: 8px; text-align: center; font-family: Arial, sans-serif; <?= $stil ?>">
                <?= $mesaj ?>
            </div>
        <?php endif; ?>

		<form name="authForm" method="POST" action="auth.php">
			<div class="form-group">
			    <label>Username</label>
			    <input type="text" name="username" class="form-control" required>
			</div>
			<div class="form-group">
			    <label>Parola</label>
			    <input type="password" name="parola" class="form-control" required>
			</div>
            <div class="wrapper">
				<button type="submit" class="btn btn-primary" name="login">LogIn</button>
			</div>
		</form>
	</div>
</body>
</html>
