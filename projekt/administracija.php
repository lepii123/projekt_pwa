<?php
include 'connect.php';
define('UPLPATH', 'images/');

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM news WHERE id=$id";
    $result = mysqli_query($dbc, $query);
}

if (isset($_POST['update'])) {
    $picture = $_FILES['pphoto']['name'];
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $archive = isset($_POST['archive']) ? 1 : 0;
    $target_dir = UPLPATH . $picture;
    move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
    $id = $_POST['id'];
    $query = "UPDATE news SET naslov='$title', sazetak='$about', tekst='$content', kategorija='$category', arhiva='$archive' WHERE id=$id";
    $result = mysqli_query($dbc, $query);
}

$query = "SELECT * FROM news";
$result = mysqli_query($dbc, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracija</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateForm() {
            let isValid = true;

            const title = document.forms["newsForm"]["title"].value;
            if (title.length < 5 || title.length > 30) {
                document.getElementById("titleError").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("titleError").style.display = "none";
            }

            const about = document.forms["newsForm"]["about"].value;
            if (about.length < 10 || about.length > 100) {
                document.getElementById("aboutError").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("aboutError").style.display = "none";
            }

            const content = document.forms["newsForm"]["content"].value;
            if (content.trim() === "") {
                document.getElementById("contentError").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("contentError").style.display = "none";
            }

            const image = document.forms["newsForm"]["pphoto"].value;
            if (image.trim() === "") {
                document.getElementById("imageError").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("imageError").style.display = "none";
            }

            const category = document.forms["newsForm"]["category"].value;
            if (category === "") {
                document.getElementById("categoryError").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("categoryError").style.display = "none";
            }

            return isValid;
        }
    </script>
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
        <section class="form-section">
            <h2>Unos nove vijesti</h2>
            <form name="newsForm" action="insert.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="form-item">
                    <label for="title">Naslov vijesti</label>
                    <div class="form-field">
                        <input type="text" name="title" class="form-field-textual" >
                        <span id="titleError" style="display:none; color:red;">Naslov vijesti mora imati između 5 i 30 znakova!</span>
                    </div>
                </div>
                <div class="form-item">
                    <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label>
                    <div class="form-field">
                        <textarea name="about" cols="30" rows="3" class="form-field-textual" maxlength="50" ></textarea>
                        <span id="aboutError" style="display:none; color:red;">Kratki sadržaj mora imati između 10 i 100 znakova!</span>
                    </div>
                </div>
                <div class="form-item">
                    <label for="content">Sadržaj vijesti</label>
                    <div class="form-field">
                        <textarea name="content" cols="30" rows="10" class="form-field-textual" ></textarea>
                        <span id="contentError" style="display:none; color:red;">Sadržaj mora biti unesen!</span>
                    </div>
                </div>
                <div class="form-item">
                    <label for="pphoto">Slika:</label>
                    <div class="form-field">
                        <input type="file" accept="image/jpg,image/gif" class="input-text" name="pphoto"/>
                        <span id="imageError" style="display:none; color:red;">Slika mora biti unesena!</span>
                    </div>
                </div>
                <div class="form-item">
                    <label for="category">Kategorija vijesti</label>
                    <div class="form-field">
                        <select name="category" class="form-field-textual" >
                            <option value="Sport">Sport</option>
                            <option value="Kultura">Kultura</option>
                        </select>
                        <span id="categoryError" style="display:none; color:red;">Kategorija mora biti odabrana!</span>
                    </div>
                </div>
                <div class="form-item">
                    <label>Spremiti u arhivu:</label>
                    <div class="form-field">
                        <input type="checkbox" name="archive">
                    </div>
                </div>
                <div class="form-item">
                    <button type="reset" value="Poništi">Poništi</button>
                    <button type="submit" value="Prihvati">Prihvati</button>
                </div>
            </form>
        
        <?php
         $i = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo '<h2>Administracija ' . $i . '. vijesti</h2>';
            echo '<form enctype="multipart/form-data" action="" method="POST">';
            echo '<div class="form-item">';
            echo '<label for="title">Naslov vjesti:</label>';
            echo '<div class="form-field">';
            echo '<input type="text" name="title" class="form-field-textual" value="'.$row['naslov'].'">';
            echo '</div></div>';

            echo '<div class="form-item">';
            echo '<label for="about">Kratki sadržaj vijesti (do 50 znakova):</label>';
            echo '<div class="form-field">';
            echo '<textarea name="about" cols="30" rows="10" class="form-field-textual">'.$row['sazetak'].'</textarea>';
            echo '</div></div>';

            echo '<div class="form-item">';
            echo '<label for="content">Sadržaj vijesti:</label>';
            echo '<div class="form-field">';
            echo '<textarea name="content" cols="30" rows="10" class="form-field-textual">'.$row['tekst'].'</textarea>';
            echo '</div></div>';

            echo '<div class="form-item">';
            echo '<label for="pphoto">Slika:</label>';
            echo '<div class="form-field">';
            echo '<input type="file" class="input-text" id="pphoto" name="pphoto"/> <br><img src="' . UPLPATH . $row['slika'] . '" width="100px">';
            echo '</div></div>';

            echo '<div class="form-item">';
            echo '<label for="category">Kategorija vijesti:</label>';
            echo '<div class="form-field">';
            echo '<select name="category" class="form-field-textual">';
            echo '<option value="sport"' . ($row['kategorija'] == 'sport' ? ' selected' : '') . '>Sport</option>';
            echo '<option value="kultura"' . ($row['kategorija'] == 'kultura' ? ' selected' : '') . '>Kultura</option>';
            echo '</select>';
            echo '</div></div>';

            echo '<div class="form-item">';
            echo '<label>Spremiti u arhivu:</label>';
            echo '<div class="form-field">';
            echo '<input type="checkbox" name="archive"' . ($row['arhiva'] == 1 ? ' checked' : '') . '/> Arhiviraj?';
            echo '</div></div>';

            echo '<input type="hidden" name="id" value="'.$row['id'].'">';
            echo '<div class="form-item">';
            echo '<button type="reset">Poništi</button>';
            echo '<button type="submit" name="update">Izmjeni</button>';
            echo '<button type="submit" name="delete">Izbriši</button>';
            echo '</div>';
            echo '</form>';
            $i++;
        }
        ?>
        </section>
    </main>

    <footer>
        <p>Author: Domagoj Lepen</p>
        <p>Email: <a href="mailto:your.email@example.com">dlepen@tvz.hr</a></p>
        <p>&copy; 2024</p>
    </footer>
</body>
</html>
