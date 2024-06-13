<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "news_database";

// Kreiranje konekcije
$conn = new mysqli($servername, $username, $password, $dbname);

// Provjera konekcije
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Provjera je li forma poslana
if (isset($_POST['naslov']) && isset($_POST['sazetak']) && isset($_POST['tekst']) && isset($_POST['kategorija'])) {
    $datum = date("d.m.Y");
    $naslov = htmlspecialchars($_POST['naslov']);
    $sazetak = htmlspecialchars($_POST['sazetak']);
    $tekst = htmlspecialchars($_POST['tekst']);
    $kategorija = htmlspecialchars($_POST['kategorija']);
    $arhiva = isset($_POST['arhiva']) ? 1 : 0;

    // Provjera i prijenos slike
    $photo = $_FILES['slika'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($photo['name']);
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Provjera je li datoteka slika
    $check = getimagesize($photo['tmp_name']);
    if ($check !== false) {
        $upload_ok = 1;
    } else {
        echo "Datoteka nije slika.";
        $upload_ok = 0;
    }

    // Provjera veličine datoteke
    if ($photo['size'] > 500000) {
        echo "Datoteka je prevelika.";
        $upload_ok = 0;
    }

    // Dopušteni formati
    if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
        echo "Samo JPG, JPEG, PNG & GIF datoteke su dopuštene.";
        $upload_ok = 0;
    }

    // Provjera je li $upload_ok postavljen na 0 zbog greške
    if ($upload_ok == 0) {
        echo "Datoteka nije prenesena.";
    // Ako je sve u redu, pokušaj prijenosa datoteke
    } else {
        if (move_uploaded_file($photo['tmp_name'], $target_file)) {
            // Pohranjivanje podataka u bazu
            $stmt = $conn->prepare("INSERT INTO news (datum, naslov, sazetak, tekst, kategorija, slika, arhiva) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssi", $datum, $naslov, $sazetak, $tekst, $kategorija, $target_file, $arhiva);

            if ($stmt->execute()) {
                echo "Podaci uspješno pohranjeni.";
            } else {
                echo "Greška prilikom pohrane podataka.";
            }

            $stmt->close();
        } else {
            echo "Došlo je do greške prilikom prijenosa datoteke.";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ažuriraj Vijest</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">franceinfo:</div>
    </header>
    <nav>
        <div class="nav-container">
            <a href="index.php">home</a>
            <a href="kategorija.php?id=sport">Sport</a>
            <a href="kategorija.php?id=kultura">Kultura</a>
            <a href="unos.php">Administracija</a>
        </div>
    </nav>

    <main>
        <section role="main">
            <h1>Nova Vijest</h1>
            <form action="update.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-item">
                    <label for="naslov">Naslov vijesti:</label>
                    <input type="text" name="naslov" value="<?php echo $news['naslov']; ?>" required>
                </div>
                <div class="form-item">
                    <label for="sazetak">Kratki sadržaj vijesti (do 50 znakova):</label>
                    <textarea name="sazetak" required><?php echo $news['sazetak']; ?></textarea>
                </div>
                <div class="form-item">
                    <label for="tekst">Sadržaj vijesti:</label>
                    <textarea name="tekst" required><?php echo $news['tekst']; ?></textarea>
                </div>
                <div class="form-item">
                    <label for="kategorija">Kategorija vijesti:</label>
                    <select name="kategorija" required>
                        <option value="sport" <?php if ($news['kategorija'] == 'sport') echo 'selected'; ?>>Sport</option>
                        <option value="kultura" <?php if ($news['kategorija'] == 'kultura') echo 'selected'; ?>>Kultura</option>
                    </select>
                </div>
                <div class="form-item">
                    <label for="slika">Slika:</label>
                    <input type="file" name="slika">
                    <?php if ($news['slika']): ?>
                        <img src="<?php echo $news['slika']; ?>" width="100px">
                    <?php endif; ?>
                </div>
                <div class="form-item">
                    <label>Spremiti u arhivu:
                        <input type="checkbox" name="arhiva" <?php if ($news['arhiva'] == 1) echo 'checked'; ?>>
                    </label>
                </div>
                <div class="form-item">
                    <button type="submit">Ažuriraj</button>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <p>Author: Domagoj Lepen</p>
        <p>Email: <a href="mailto:your.email@example.com">dlepen@tvz.hr</a></p>
        <p>&copy; 2024</p>
    </footer>
</body>
</html>
