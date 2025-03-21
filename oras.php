<?php
$con = mysqli_connect('localhost:3307', 'root', '', 'ghid_turistic');

if (!$con) {
    die("Conexiunea a eșuat: " . mysqli_connect_error());
}

// Verificăm dacă avem parametrii necesari
if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['categorie'])) {
    die("Date invalide!");
}

$id = intval($_GET['id']);
$categorie = $_GET['categorie']; // Categoria trebuie să fie specificată în URL

// Lista de tabele pentru fiecare categorie
$tabele = [
    'orase'  => 'detalii_orase',
    'orased' => 'detalii_orased',
    'statb'  => 'detalii_statb',
    'statm'  => 'detalii_statm',
    'statl'  => 'detalii_statl'
];

// Verificăm dacă categoria este validă
if (!array_key_exists($categorie, $tabele)) {
    die("Categorie invalidă!");
}

// Selectăm datele principale din tabela corespunzătoare
$sql_dest = "SELECT * FROM $categorie WHERE id = $id";
$result_dest = mysqli_query($con, $sql_dest);

if (!$result_dest || mysqli_num_rows($result_dest) == 0) {
    die("Destinația nu a fost găsită!");
}

$row_dest = mysqli_fetch_assoc($result_dest);

// Selectăm detaliile din tabela corespunzătoare
$tabela_detalii = $tabele[$categorie];
$sql_detalii = "SELECT * FROM $tabela_detalii WHERE orase_id = $id";
$result_detalii = mysqli_query($con, $sql_detalii);

if (!$result_detalii || mysqli_num_rows($result_detalii) == 0) {
    $row_detalii = null; // Nu avem detalii suplimentare
} else {
    $row_detalii = mysqli_fetch_assoc($result_detalii);
}

// Convertim lista de imagini într-un array doar dacă există imagini
$imagini = [];
if (!empty($row_detalii['galerie_foto'])) {
    $imagini = explode(',', $row_detalii['galerie_foto']);
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row_dest['nume']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
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

        .container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
            margin-right: 165px;
        }
        .container img {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
            cursor: pointer;
        }
        h1 {
            color: #2c3e50;
        }
        p {
            color: #555;
            font-size: 18px;
            line-height: 1.6;
            text-align: justify;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        .gallery img {
            width: 45%;
            height: auto;
            border-radius: 8px;
            cursor: pointer;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background-color: #34495e;
        }
        /* Stilizare pentru modal (zoom pe imagine) */
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
        <a href="locuridevizitat.php?id=<?php echo $id; ?>">Locuri de vizitat</a>
        <a href="#">Hoteluri</a>
        <a href="#">Restaurante</a>
        <a href="orase.php?categorie=<?php echo htmlspecialchars($categorie === 'orased' ? 'delta' : $categorie); ?>">Înapoi</a>
        </div>
    <div class="container">
        <h1><?php echo htmlspecialchars($row_dest['nume']); ?></h1>

        <?php if (!empty($imagini)): ?>
            <img src="<?php echo htmlspecialchars(trim($imagini[0])); ?>" onclick="openModal(this.src)">
        <?php else: ?>
            <p>Nu există imagini disponibile.</p>
        <?php endif; ?>

        <?php if ($row_detalii): ?>
            <p><?php echo htmlspecialchars($row_detalii['descriere_lunga']); ?></p>
        <?php else: ?>
            <p>Nu există detalii suplimentare pentru această destinație.</p>
        <?php endif; ?>

        <div class="gallery">
            <?php if (count($imagini) > 1): ?>
                <?php foreach (array_slice($imagini, 1) as $img): ?>
                    <img src="<?php echo htmlspecialchars(trim($img)); ?>" onclick="openModal(this.src)">
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        
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
