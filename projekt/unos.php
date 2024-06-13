<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unos Vijesti</title>
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
        <section class="form-section">
            <h2>Unos Vijest</h2>
            <form action="insert.php" method="POST" enctype="multipart/form-data">
                <div class="form-item">
                    <label for="title">Naslov vijesti</label>
                    <div class="form-field">
                        <input type="text" name="title" class="form-field-textual" required>
                    </div>
                </div>
                <div class="form-item">
                    <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label>
                    <div class="form-field">
                        <textarea name="about" cols="30" rows="3" class="form-field-textual" maxlength="50" required></textarea>
                    </div>
                </div>
                <div class="form-item">
                    <label for="content">Sadržaj vijesti</label>
                    <div class="form-field">
                        <textarea name="content" cols="30" rows="10" class="form-field-textual" required></textarea>
                    </div>
                </div>
                <div class="form-item">
                    <label for="pphoto">Slika:</label>
                    <div class="form-field">
                        <input type="file" accept="image/jpg,image/gif" class="input-text" name="pphoto" required/>
                    </div>
                </div>
                <div class="form-item">
                    <label for="category">Kategorija vijesti</label>
                    <div class="form-field">
                        <select name="category" class="form-field-textual" required>
                            <option value="Sport">Sport</option>
                            <option value="Kultura">Kultura</option>
                        </select>
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
        </section>
    </main>

    <footer>
        <p>Author: Domagoj Lepen</p>
        <p>Email: <a href="mailto:your.email@example.com">dlepen@tvz.hr</a></p>
        <p>&copy; 2024</p>
    </footer>
</body>
</html>
