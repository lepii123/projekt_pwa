<?php
include 'connect.php';
define('UPLPATH', 'images/');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Franceinfo</title>
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
            <h2>Sport</h2>
            <div class="news-grid">
                <?php
                $query = "SELECT * FROM news WHERE kategorija='sport' AND arhiva=0 LIMIT 5";
                $result = mysqli_query($dbc, $query);
                
                while ($row = mysqli_fetch_array($result)) {
                    echo '<div class="news-item">';
                    echo '<img src="' . UPLPATH . $row['slika'] . '" alt="News Image">';
                    echo '<p>' . $row['naslov'] . '</p>';
                    echo '<p>' . $row['sazetak'] . '</p>';
                    echo '<a href="clanak.php?id=' . $row['id'] . '">Read more</a>';
                    echo '</div>';
                }
                ?>
            </div>
        </section>

        <section class="jt-section">
            <h2>Kultura</h2>
            <div class="jt-grid">
                <?php
                $query = "SELECT * FROM news WHERE kategorija='kultura' AND arhiva=0 LIMIT 4";
                $result = mysqli_query($dbc, $query);
                
                while ($row = mysqli_fetch_array($result)) {
                    echo '<div class="jt-item">';
                    echo '<img src="' . UPLPATH . $row['slika'] . '" alt="JT Image">';
                    echo '<p>' . $row['naslov'] . '</p>';
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
