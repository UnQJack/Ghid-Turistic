<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoteluri</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
        }

        .sidebar {
            width: 200px;
            height: 100vh;
            background-color: #2c3e50;
            color: white;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 15px;
            display: block;
            font-size: 18px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .main-content {
            margin-left: 200px;
            width: calc(100% - 200px);
            padding: 20px;
        }

        .hotel {
            display: flex;
            flex-direction: column;
            margin-bottom: 40px;
            border-bottom: 1px;
            padding-bottom: 20px;
        }

        .top-section {
            display: flex;
            align-items: flex-start;
        }

        .image-container {
            width: 200px;
        }

        .image-container img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            cursor: pointer;
        }

        .hotel-info {
            margin-left: 20px;
            flex-grow: 1;
        }

        .hotel-info h2 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .hotel-info p {
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .hotel-info .stars {
            color: gold;
            font-size: 20px;
        }

        .hotel-details {
            margin-top: 5px;
        }

        .hotel-details p {
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            display: block;
            margin: auto;
            max-width: 80%;
            max-height: 80%;
            margin-top: 5%;
            border-radius: 8px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            color: white;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <?php
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;
        $categorie = isset($_GET['categorie']) && !empty($_GET['categorie']) ? urlencode($_GET['categorie']) : 'orase';
        echo '<a href="oras.php?id=' . $id . '&categorie=' . $categorie . '">Înapoi</a>';
        ?>
    </div>

    <div class="main-content">
    <?php
    $con = mysqli_connect('localhost:8889', 'root', 'root', 'ghid_turistic');

    if (!$con) {
        die("Conexiunea a eșuat: " . mysqli_connect_error());
    }

    // Obține ID-ul și categoria din URL
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;
    $categorie = isset($_GET['categorie']) && !empty($_GET['categorie']) ? $_GET['categorie'] : 'orase';

    if ($id !== null) {
        // Ajustează query-ul în funcție de categoria selectată
        if ($categorie == 'orased') {
            $sql = "SELECT * FROM hoteluri_delta WHERE orased_id = $id";
        } 
        else if($categorie == 'statb') {
            $sql = "SELECT * FROM hoteluri_statb WHERE statb_id = $id";
        }
        else if($categorie == 'statl') {
            $sql = "SELECT * FROM hoteluri_statbl WHERE statb_id = $id";
        }
        else if($categorie == 'statm') {
            $sql = "SELECT * FROM hoteluri_statm WHERE statb_id = $id";
        }
        else {
            $sql = "SELECT * FROM hoteluri WHERE orase_id = $id";
        }

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='hotel'>
                        <div class='top-section'>
                            <div class='image-container'>
                                <img src='" . $row['imagine'] . "' onclick='openModal(this.src)'>
                            </div>
                            <div class='hotel-info'>
                                <h2>" . htmlspecialchars($row['nume']) . "</h2>
                                <p><strong>Adresă:</strong> " . htmlspecialchars($row['adresa']) . "</p>
                                <p><strong>Nr. Telefon:</strong> " . htmlspecialchars($row['numar_telefon']) . "</p>
                                <p><strong>Website:</strong> <a href='" . htmlspecialchars($row['website']) . "' target='_blank'>" . htmlspecialchars($row['website']) . "</a></p>
                                <p><strong>Stele:</strong> <span class='stars'>";
                                    for ($i = 0; $i < (int)$row['stele']; $i++) {
                                        echo "★";
                                    }
                                echo "</span></p>
                            </div>
                        </div>
                        <div class='hotel-details'>
                            <p><strong>Descriere:</strong> " . htmlspecialchars($row['descriere_lunga']) . "</p>
                            <p><strong>Facilități:</strong> " . htmlspecialchars($row['facilitati']) . "</p>
                            <p><strong>Tipul Camerei:</strong> " . htmlspecialchars($row['camere']) . "</p>
                            <p><strong>Preț:</strong> " . htmlspecialchars($row['pret'] ?? 'N/A') . " Lei/Noapte</p>
                        </div>
                      </div>";
            }
        } else {
            echo "<p style='text-align: center;'>Nu s-au găsit hoteluri în această categorie.</p>";
        }
    } else {
        echo "<p style='text-align: center;'>ID invalid sau parametru lipsă.</p>";
    }

    mysqli_close($con);
    ?>
</div>

    <!-- Modal pentru zoom -->
    <div id="zoomModal" class="modal" onclick="closeModal()">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalImage" class="modal-content" onclick="closeModal()">
    </div>

    <script>
        function openModal(src) {
            document.getElementById("zoomModal").style.display = "block";
            document.getElementById("modalImage").src = src;
        }
        function closeModal() {
            document.getElementById("zoomModal").style.display = "none";
        }
    </script>
</body>
</html>
