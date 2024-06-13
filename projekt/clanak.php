<?php
include 'connect.php';
define('UPLPATH', 'images/');

$id = $_GET['id'];
$query = "SELECT * FROM news WHERE id=$id";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['naslov']; ?></title>
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
        <div>
            <h2 class="category"><?php echo "<span>".$row['kategorija']."</span>"; ?></h2>
            <h1 class="title"><?php echo $row['naslov']; ?></h1>
            <p>AUTOR: Domagoj Lepen</p>
            <p>OBJAVLJENO: <?php echo "<span>".$row['datum']."</span>"; ?></p>
        </div>
        <section class="article-item">
            <?php echo '<img src="' . UPLPATH . $row['slika'] . '">'; ?>
        </section>
        <section class="sazetak">
            <p><?php echo "<i>".$row['sazetak']."</i>"; ?></p>
        </section>
        <section class="sadrzaj">
            <p><?php echo $row['tekst']; ?></p>
        </section>
    </section>
    </main>
    <footer>
        <p>Author: Domagoj Lepen</p>
        <p>Email: <a href="mailto:dlepen@tvz.hr">dlepen@tvz.hr</a></p>
        <p>&copy; 2024</p>
    </footer>
</body>
</html>
