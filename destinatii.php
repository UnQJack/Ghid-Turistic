<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinatii turistice</title>
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

        .view-more {
            display: inline-block;
            padding: 10px 15px;
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .view-more:hover {
            background-color: #34495e;
        }

        /* Modal pentru zoom */
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
    <a href="orase.php?categorie=orase">Orașe turistice</a>
    <a href="orase.php?categorie=delta">Lunca și Delta Dunării</a>
    <a href="orase.php?categorie=balneare">Stațiuni balneare</a>
    <a href="orase.php?categorie=litorale">Stațiuni litorale</a>
    <a href="orase.php?categorie=montane">Stațiuni montane</a>
        <a href="homepage.html">Înapoi</a>
    </div>

    <div class="main-content">
        <?php
        $con = mysqli_connect('localhost:3307', 'root', '', 'ghid_turistic');

        if (!$con) {
            die("Conexiunea a eșuat: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM destinatii";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='destination'>
                    <div class='image-container'>
                        <img src='" . $row['imagine'] . "' onclick='openModal(this.src)'>
                    </div>
                    <div class='text-content'>
                        <h2>" . $row['nume'] . "</h2>
                        <p>" . $row['descriere'] . "</p>
                        <a href='destinatie.php?id=" . $row['id'] . "' class='view-more'>Vezi Detalii</a>
                    </div>
                  </div>";
            }
        } else {
           echo "<p style='text-align: center;'>Nu s-au găsit destinații.</p>";
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
