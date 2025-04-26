<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locuri de vizitat</title>
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

        .destination {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
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

        .text-content {
            width: 65%;
        }

        .text-content h2 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .text-content p {
            margin-bottom: 15px;
            color: #555;
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
        if ($id !== null) {
            echo '<a href="oras.php?id=' . $id . '&categorie=' . $categorie . '">Înapoi</a>';
        } else {
            echo '<a href="oras.php?id=' . $id . '&categorie=' . $categorie . '">Înapoi</a>';
        }
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
                $sql = "SELECT * FROM locuri_vizitat_delta WHERE orased_id = $id";
            } 
            else if ($categorie == 'statb') {
                $sql = "SELECT * FROM locuri_vizitat_statb WHERE orase_id = $id";
            }
            else {
                $sql = "SELECT * FROM locuri_vizitat WHERE orase_id = $id";
            }
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='destination'>
                        <div class='image-container'>
                            <img src='" . $row['imagine'] . "' onclick='openModal(this.src)'>
                        </div>
                        <div class='text-content'>
                        <h2>" . htmlspecialchars($row['nume']) . "</h2>
                        <p>" . htmlspecialchars($row['descriere']) . "</p>
                        </div>
                    </div>";
                }
            } else {
                echo "<p style='text-align: center;'>Nu s-au găsit locuri de vizitat în această categorie.</p>";
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
