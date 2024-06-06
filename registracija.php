<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        
        include "connect.php";

        $stmt_check = $conn->prepare("SELECT id FROM korisnik WHERE user = ?");
        $stmt_check->bind_param("s", $username);
        $username = $_POST['username'];
        $stmt_check->execute();
        $stmt_check->store_result();
        if ($stmt_check->num_rows > 0) {
            echo "Korisnik s tim imenom već postoji.";
        } else {
            $stmt_insert = $conn->prepare("INSERT INTO korisnik (user, pass) VALUES (?, ?)");
            $stmt_insert->bind_param("ss", $username, $password);

            $username = $_POST['username'];
            $password = $_POST['password'];
            $stmt_insert->execute();

            echo "Korisnik uspješno registriran. ";
            echo "<a href=prijavasite.php>Prijavite se</a>";

            $stmt_insert->close();
        }

        $stmt_check->close();
        $conn->close();
    } else {
        echo "Molimo ispunite sva polja.";
    }
}
?>
