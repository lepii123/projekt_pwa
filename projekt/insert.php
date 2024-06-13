<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $picture = $_FILES['pphoto']['name'];
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $date = date('d.m.Y.');
    $archive = isset($_POST['archive']) ? 1 : 0;
    
    $target_dir = 'images/'.$picture;
    move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
    
    $query = "INSERT INTO news (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) VALUES ('$date', '$title', '$about', '$content', '$picture', '$category', '$archive')";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    
    mysqli_close($dbc);

    header("Location: administracija.php");
}
?>
