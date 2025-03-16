<?php
$con = mysqli_connect('localhost:3307', 'root', '', 'ghid_turistic');

if (!$con) {
    die("Conexiunea a eșuat: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $parola = $_POST['parola'];

    // Verifică dacă username-ul există deja
    $check_query = "SELECT * FROM auth WHERE username = ?";
    $stmt = $con->prepare($check_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "
            <div style='width: 50%; margin: 50px auto; padding: 20px; border-radius: 10px; text-align: center; font-family: Arial, sans-serif;'>
                <h2 style='color: black;'>Autentificare cu succes</h2>
                <a href='homepage.html' style='display: inline-block; padding: 10px 20px; background: #2c3e50; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;'>
                    Înapoi la pagina principala
                </a>
            </div>";
    } else {
        // Criptează parola înainte de a o salva
        $parola_hash = password_hash($parola, PASSWORD_DEFAULT);

        if ($stmt->execute()) {
            echo "
            <div style='width: 50%; margin: 50px auto; padding: 20px; border-radius: 10px; text-align: center; font-family: Arial, sans-serif;'>
                <h2 style='color: black;'>Eroare: Username/parola incorecte!</h2>
                <a href='auth.html' style='display: inline-block; padding: 10px 20px; background: #2c3e50; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;'>
                    Înapoi la autentificare
                </a>
            </div>";
        } else {
            echo "Eroare la înregistrare: " . mysqli_error($con);
        }
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
		<form name="authForm" method="POST" action="auth.php">
			<div class="form-group">
			    <label>Username</label>
			    <input type="text" name="username" class="form-control" id="inputText" required>
			</div>
			<div class="form-group">
			    <label>Parola</label>
			    <input type="parola" name="parola" class="form-control" id="inputText" required>
			</div>
            <div class="wrapper">
				<button type="submit" class="btn btn-primary" ng-click="performValidation()" name='login'>LogIn</button>
			</div>
		</form>
	</div>
</body>
</html>