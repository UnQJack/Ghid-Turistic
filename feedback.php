<?php
$con = mysqli_connect('localhost:8889', 'root', 'root', 'ghid_turistic');

// Verifică conexiunea
if (!$con) {
    die("Conexiunea a eșuat: " . mysqli_connect_error());
}

// Verifică dacă datele au fost trimise
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $feedback = htmlspecialchars($_POST['feedbk']);

    // Inserează în baza de date
    $que = "INSERT INTO feedback (name, email, feedbk) VALUES ('$name', '$email', '$feedback')";
    if (mysqli_query($con, $que)) {
        echo "
        <div style='width: 50%; margin: 50px auto; padding: 20px; border-radius: 10px; text-align: center; font-family: Arial, sans-serif;'>
            <h2 style='color: black;'>Mulțumim, $name!</h2>
            <p>Feedback-ul tău a fost înregistrat cu succes.</p>
            <a href='feedback.php' style='display: inline-block; padding: 10px 20px; background: #2c3e50; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;'>
                Înapoi la formular
            </a>
        </div>";
    } else {
        echo "Eroare la trimiterea feedback-ului: " . mysqli_error($con);
    }
} else {
    echo "Cerere invalidă!";
}

// Închide conexiunea
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Feedback Form</title>
	<link rel="stylesheet" type="text/css" href="feedback.css">
</head>
<body>
    <div class="sidebar">
        <a href="homepage.html">Înapoi</a>
    </div>
	<div class="feedback">
		<h1 style="color: #2c3e50;">Feedback Form</h1>
		<form name="feedbackForm" method="POST" action="feedback.php">
			<div class="form-group">
			    <label>Your Name</label>
			    <input type="text" name="name" class="form-control" id="inputText" required>
			</div>
			<div class="form-group">
			    <label>Your Email</label>
			    <input type="email" name="email" class="form-control" id="inputEmail" required>
			</div>
			<div class="form-group text1">
			    <label>Feedback:</label>
			    <textarea class="inputTextarea" name="feedbk" rows="4" class="form-control" ng-model='feedback' required></textarea>
			</div>
			<div class="wrapper">
				<button type="submit" class="btn btn-primary" ng-click="performValidation()" name='submit'>Submit Feedback</button>
			</div>
		</form>
	</div>
</body>
</html>