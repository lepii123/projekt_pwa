<?php
include 'connect.php';
define('UPLPATH', 'images/');

$category = $_GET['id'];  // Get the category from the URL parameter
$query = "SELECT * FROM news WHERE kategorija='$category' AND arhiva=0";
$result = mysqli_query($dbc, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($category); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">Vijesti</div>
    </header>
    <nav>
        <div class="nav-container">
        <a href="index.php">Home</a>
        <a href="kategorija.php?id=Sport">Sport</a>
        <a href="kategorija.php?id=Kultura">Kultura</a>
        <a href="registracija.php">Administracija</a>
        <a href="logout.php">logout</a>
        </div>
    </nav>

    <main>
        <section class="news-section">
            <h2><?php echo ucfirst($category); ?></h2>
            <div class="news-grid">
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    echo '<div class="news-item">';
                    echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . $row['naslov'] . '">';
                    echo '<h3>' . $row['naslov'] . '</h3>';
                    echo '<p>' . $row['sazetak'] . '</p>';
                    echo '<a href="clanak.php?id=' . $row['id'] . '">Read more</a>';
                    echo '</div>';
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>Author: Domagoj Lepen</p>
        <p>Email: <a href="mailto:your.email@example.com">dlepen@tvz.hr</a></p>
        <p>&copy; 2024</p>
    </footer>
</body>
</html>
