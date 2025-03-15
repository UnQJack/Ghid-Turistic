<?php
$con = mysqli_connect('localhost:3307', 'root', '', 'ghid_turistic');

if (!$con) {
    die("Conexiunea a eșuat: " . mysqli_connect_error());
}

// Verificăm dacă avem un ID valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Destinația nu există!");
}

$id = intval($_GET['id']);  

// Interogăm datele principale din `destinatii`
$sql_dest = "SELECT * FROM destinatii WHERE id = $id";
$result_dest = mysqli_query($con, $sql_dest);

if (mysqli_num_rows($result_dest) == 0) {
    die("Destinația nu a fost găsită!");
}

$row_dest = mysqli_fetch_assoc($result_dest);

// Interogăm datele extinse din `detalii_destinatii`
$sql_detalii = "SELECT * FROM detalii_destinatii WHERE destinatie_id = $id";
$result_detalii = mysqli_query($con, $sql_detalii);
$row_detalii = mysqli_fetch_assoc($result_detalii);

// Convertim lista de imagini într-un array
$imagini = explode(',', $row_detalii['galerie_foto']);

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row_dest['nume']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .container img {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
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
            transition: transform 0.3s;
        }
        .gallery img:hover {
            transform: scale(1.1);
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
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $row_dest['nume']; ?></h1>
        <img src="<?php echo $row_dest['imagine']; ?>">
        <p><?php echo $row_detalii['descriere_lunga']; ?></p>
        <div class="gallery">
            <?php foreach ($imagini as $img): ?>
                <img src="<?php echo trim($img); ?>">
            <?php endforeach; ?>
        </div>

        <a href="destinatii.php" class="back-btn">Înapoi</a>
    </div>
</body>
</html>
