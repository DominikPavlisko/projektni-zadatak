<?php
if (session_status() == 1) {
    session_start();
}

include "connect.php";

if(isset($_SESSION['user_id'])) {
    if ($_SESSION['user_level'] == 1) {
        header("Location: administracijasite.php");
        exit();
    } else {
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['odjava'])) {
        session_unset();
        session_destroy();
        header("Location: prijavasite.php");
        exit();
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM korisnik WHERE user='$username' AND pass='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['id'];
            $user_level = $row['razina'];

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_level'] = $user_level;

            if ($user_level == 1) {
                header("Location: administracijasite.php");
                exit();
            } else {
            }
        } else {
            echo "Pogrešno korisničko ime ili lozinka.<a href=index.php?data=home>Povratak na naslovnicu!</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon-32x32.png">
    <title>Newsweek</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <?php if(isset($_SESSION['user_id'])): ?>
        <h1 class="odjava">Uspješno ste prijavljeni!</h1>
        <form action="" method="post" class="odjavabutton">
            <button type="submit" name="odjava">Logout</button>
        </form>
    <?php else: ?>
        <div class="login-container">
            <div class="loginadjust">
                <h2>Prijava</h2>
                <form action="" method="post">
                    <div class="input-group">
                        <label for="username">Korisničko ime:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Lozinka:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">Prijavi se</button>
                </form>
                <a href="registracijasite.php">Izradi račun?</a>
            </div>
        </div>
    <?php endif; ?>

    <?php include 'footer.html'; ?>
</body>
</html>
