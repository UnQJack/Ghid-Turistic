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
            margin-bottom: 40px;
            border-bottom: 1px;
            padding-bottom: 20px;
        }

        .image-container {
            width: 20%;
        }

        .image-container img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            cursor: pointer;
        }

        .hotel-info {
            width: 70%;
        }

        .hotel-info h2 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .hotel-info p {
            margin-bottom: 10px;
            color: #555;
        }

        .hotel-info .stars {
            color: gold;
            font-size: 20px;
        }

        .hotel-description {
            margin-left: -20px;
            width: calc(100% + 20px);
        }

        .hotel-info {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
        $con = mysqli_connect('localhost:3307', 'root', '', 'ghid_turistic');

        if (!$con) {
            die("Conexiunea a eșuat: " . mysqli_connect_error());
        }

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM hoteluri WHERE orase_id = $id";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='hotel'>
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
                                <div class='hotel-description'>
                                    <p><strong>Descriere:</strong> " . htmlspecialchars($row['descriere_lunga']) . "</p>
                                    <p><strong>Facilități:</strong> " . htmlspecialchars($row['facilitati']) . "</p>
                                    <p><strong>Tipul Camerei:</strong> " . htmlspecialchars($row['camere']) . "</p>
                                    <p><strong>Preț:</strong> " . htmlspecialchars($row['pret'] ?? 'N/A') . " Lei/Noapte</p>
                                </div>
                            </div>
                          </div>";
                }
            } else {
                echo "<p style='text-align: center;'>Nu s-au găsit hoteluri în acest oraș.</p>";
            }
        } else {
            echo "<p style='text-align: center;'>Oraș invalid sau parametru lipsă.</p>";
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
