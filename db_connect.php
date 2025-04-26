<?php
$servername = "localhost:8889";
$username = "root";  
$password = "root";      // Parola default la WAMP este goală
$database = "ghid_turistic";

$conn = new mysqli($servername, $username, $password, $database);

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
} else {
    echo "Baza de date verificată! Conectare reușită!";
}
