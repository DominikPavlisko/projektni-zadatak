<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["komentar"]) && !empty($_POST["komentar"])) {
        include "connect.php";
        $data = $_POST['data'];

        if(isset($_SESSION['user_id'])) {
            $korisnik_id = $_SESSION['user_id'];
            $komentar = $_POST["komentar"];
            $sql_insert = "INSERT INTO komentar (sadrzaj, id_vijesti, id_korisnika, objavljeno) VALUES ('$komentar', '$data', '$korisnik_id', NOW())";

            if ($conn->query($sql_insert) === TRUE) {
                header("Location: vijest.php?data=$data", true, 301); 
                exit();
            } else {
                echo "Greška prilikom dodavanja komentara: " . $conn->error;
            }
        } else {
            header("Location: prijavasite.php");
            exit();
        }

        $conn->close();
    }
}
?>
