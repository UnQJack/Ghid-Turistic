<?php
// Conectare la baza de date
$con = new mysqli('localhost', 'root', '', 'ghid_turistic', 3307);

// Verificare conexiune
if ($con->connect_error) {
    die("Eroare la conectare: " . $con->connect_error);
}

// Interogare pentru a lua toate destinațiile
$sql = "SELECT * FROM destinatii";
$result = $con->query($sql);

// Verificăm dacă sunt destinații în baza de date
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="destination">
                <div class="image-container">
                    <img src="' . htmlspecialchars($row["imagine"]) . '" alt="' . htmlspecialchars($row["nume"]) . '">
                </div>
                <div class="text-content">
                    <h2>' . htmlspecialchars($row["nume"]) . '</h2>
                    <p>' . htmlspecialchars($row["descriere"]) . '</p>
                    <a href="destinatie.php?id=' . $row["id"] . '" class="view-more">View More</a>
                </div>
              </div>';
    }
} else {
    echo "<p>Nu există destinații disponibile.</p>";
}

// Închidere conexiune
$con->close();
?>
