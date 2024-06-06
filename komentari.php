<?php
include "connect.php";

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_level = $_SESSION['user_level'];
} else {
    $user_id = null;
    $user_level = null;
}

$sql = "SELECT komentar.id, komentar.sadrzaj, korisnik.user, komentar.objavljeno, korisnik.id as id_korisnika
        FROM komentar
        JOIN korisnik ON komentar.id_korisnika = korisnik.id
        WHERE komentar.id_vijesti =" . $data . "
        ORDER BY komentar.objavljeno DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<article class='komentar'>";
        echo "<div class='komentardiv'>";
        echo "<p class='imekorisnika'>" . $row["user"] . "</p>";
        if ($row["id_korisnika"] == $user_id || $user_level == 1) {
            echo "<a class='brisanje' href='obrisikomentar.php?id=" . $row["id"] . "'><i class='fas fa-trash-alt'></i></a>";
        }
        echo "</div>";
        echo "<p>" . $row["sadrzaj"] . "</p>";
        echo "</article>";
    }
} else {

}
?>
