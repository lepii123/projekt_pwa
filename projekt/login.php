<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include 'connect.php';
session_start();
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $lozinka = $_POST['pass'];

    // Provjera korisnika u bazi
    $sql = "SELECT lozinka FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $hashed_password);
        mysqli_stmt_fetch($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            if (password_verify($lozinka, $hashed_password)) {
                $_SESSION['username'] = $username;
                echo '<p class="success-message">Login successful! Redirecting to the admin page...</p>';
                echo '<meta http-equiv="refresh" content="2;url=administracija.php">';
            } else {
                $msg = 'Incorrect password!';
            }
        } else {
            $msg = 'User does not exist!';
        }
    }
    mysqli_close($dbc);
}

if (empty($_SESSION['username'])) {
?>

<section role="main" class ="form-section2">
    <form enctype="multipart/form-data" action="" method="POST">
        <div class="form-item">
            <span id="porukaUsername" class="bojaPoruke"></span>
            <label for="username">Korisničko ime:</label>
            <?php echo '<br><span class="bojaPoruke">'.$msg.'</span>'; ?>
            <div class="form-field">
                <input type="text" name="username" id="username">
            </div>
        </div>
        <div class="form-item">
            <span id="porukaPass" class="bojaPoruke"></span>
            <label for="pass">Lozinka: </label>
            <div class="form-field">
                <input type="password" name="pass" id="pass">
            </div>
        </div>
        <div class="form-item">
            <button type="submit" value="Prijava" id="slanje">Prijava</button>
        </div>
    </form>
</section>

<script type="text/javascript">
document.getElementById("slanje").onclick = function(event) {
    var slanjeForme = true;

    // Korisničko ime mora biti uneseno
    var poljeUsername = document.getElementById("username");
    var username = document.getElementById("username").value;
    if (username.length == 0) {
        slanjeForme = false;
        poljeUsername.style.border = "1px dashed red";
        document.getElementById("porukaUsername").innerHTML = "<br>Unesite korisničko ime!<br>";
    } else {
        poljeUsername.style.border = "1px solid green";
        document.getElementById("porukaUsername").innerHTML = "";
    }

    // Lozinka mora biti unesena
    var poljePass = document.getElementById("pass");
    var pass = document.getElementById("pass").value;
    if (pass.length == 0) {
        slanjeForme = false;
        poljePass.style.border = "1px dashed red";
        document.getElementById("porukaPass").innerHTML = "<br>Unesite lozinku!<br>";
    } else {
        poljePass.style.border = "1px solid green";
        document.getElementById("porukaPass").innerHTML = "";
    }

    if (!slanjeForme) {
        event.preventDefault();
    }
};
</script>

<?php
} else {
    echo '<p class="success-message">Već ste ulogirani. <a href="administracija.php">Go to admin page</a></p>';
}
?>

</body>
</html>
