<?php

include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['delete_title'])) {
        $naslov_za_brisanje = $_POST['delete_title'];

        $select_stmt = $conn->prepare("SELECT COUNT(*) FROM vijesti WHERE slika = (SELECT slika FROM vijesti WHERE naslov = ?)");
        $select_stmt->bind_param("s", $naslov_za_brisanje);
        $select_stmt->execute();
        $select_stmt->bind_result($broj_vijesti);
        $select_stmt->fetch();
        $select_stmt->close();

        if ($broj_vijesti == 1) {
            $select_image_stmt = $conn->prepare("SELECT slika FROM vijesti WHERE naslov = ?");
            $select_image_stmt->bind_param("s", $naslov_za_brisanje);
            $select_image_stmt->execute();
            $select_image_stmt->bind_result($slika);
            $select_image_stmt->fetch();
            $select_image_stmt->close();

            $delete_stmt = $conn->prepare("DELETE FROM vijesti WHERE naslov = ?");
            $delete_stmt->bind_param("s", $naslov_za_brisanje);

            if ($delete_stmt->execute()) {
                echo "Podaci s naslovom \"$naslov_za_brisanje\" uspješno izbrisani iz baze.";

                if(!empty($slika) && file_exists("$slika")) {
                    unlink("$slika");
                    echo "Slika \"$slika\" je uspješno izbrisana.";
                } else {
                    echo "Slika nije pronađena ili već izbrisana.";
                }

                ?>
                <script type="text/javascript">
                window.location = "administracijasite.php";
                </script>
                <?php
            } else {
                echo "Greška prilikom brisanja podataka: " . $delete_stmt->error;
            }

            $delete_stmt->close();
        } else {
            $delete_stmt = $conn->prepare("DELETE FROM vijesti WHERE naslov = ?");
            $delete_stmt->bind_param("s", $naslov_za_brisanje);

            if ($delete_stmt->execute()) {
                echo "Podaci s naslovom \"$naslov_za_brisanje\" uspješno izbrisani iz baze.";

                ?>
                <script type="text/javascript">
                window.location = "administracijasite.php";
                </script>
                <?php
            } else {
                echo "Greška prilikom brisanja podataka: " . $delete_stmt->error;
            }

            $delete_stmt->close();
        }
    }
}
?>
