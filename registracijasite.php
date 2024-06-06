<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon-32x32.png">
    <title>Newsweek</title>
    <link rel="stylesheet" href="login.css">
    <script>
        function showPassword(id) {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <?php
    include "connect.php";

    if(isset($_SESSION['user_id'])) {
        header("Location: odjavasite.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

            header("Location: odjavasite.php");
            exit();
        } else {
            echo "Pogrešno korisničko ime ili lozinka.<a href=index.php?data=home>Povratak na naslovnicu!</a>";
        }
    }
    ?>

    <div class="login-container">
        <div class="loginadjust">
        <h2>Registracija</h2>
        <form action="registracija.php" method="post">
            <div class="input-group">
                <label for="username">Korisničko ime:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Lozinka:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <input type="checkbox" id="show_password" onclick="showPassword(password)">
                <label for="show_password">Prikaži lozinku</label>
            </div>
            <button type="submit">Registriraj se</button>
        </form>
        </div>
    </div>

    <?php include 'footer.html'; ?>
</body>
</html>
