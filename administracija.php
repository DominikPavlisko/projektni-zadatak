<?php

include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naslov = $_POST['naslov'];
    $kategorija = ($_POST['kategorija'] === 'custom') ? $_POST['custom_kategorija'] : $_POST['kategorija'];
    $sadrzaj = $_POST['sadrzaj'];
    
    $target_dir = "uploads/";
    
    $target_file = $target_dir . basename($_FILES['slika']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES['slika']['tmp_name'], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO vijesti (naslov, kategorija, slika, sadrzaj, datum) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $naslov, $kategorija, $target_file, $sadrzaj);

        if ($stmt->execute()) {
            echo "Podaci uspješno uneseni u bazu.";
            ?>
            <script type="text/javascript">
            window.location = "administracijasite.php";
            </script>
            <?php
        } else {
            echo "Greška prilikom unosa podataka: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Greska!";
    }
}

$conn->close();
?>
