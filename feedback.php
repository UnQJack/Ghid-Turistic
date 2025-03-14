<?php
$con = mysqli_connect('localhost:3307', 'root', '', 'ghid_turistic');

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
            <a href='feedback.html' style='display: inline-block; padding: 10px 20px; background: #2c3e50; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;'>
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
