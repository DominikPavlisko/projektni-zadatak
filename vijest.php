<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="favicon-32x32.png">
    <title>Newsweek</title>
    <link rel="stylesheet" href="vijest.css">
</head>
<body>
<?php include 'header.php'; ?>

<section>
    <?php 

    include "connect.php";

    $data = isset($_GET['data']) ? intval($_GET['data']) : 0;

    $sql = "SELECT id, naslov, slika, kategorija, sadrzaj, datum FROM vijesti WHERE id = " . $data;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<article>";
            echo "<h3 class='lokacija'>" . htmlspecialchars($row["kategorija"]) . "</h3>";
            echo "<h2>" . htmlspecialchars($row["naslov"]) . "</h2>";
            echo "<div class='datum'>" . date('d/m/y', strtotime($row["datum"])) . "</div>";
            echo '<img src="' . htmlspecialchars($row['slika']) . '" width="50%"/>';
            echo "<h3 class='kocka'>" . htmlspecialchars($row["kategorija"]) . "</h3>";
            echo "<p>" . $row["sadrzaj"] . "</p>";
            echo "</article>";
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    ?> 
</section>

<hr class="line2">

<div class="vise">
    <?php 

    $data = isset($_GET['data']) ? intval($_GET['data']) : 0;

    include "connect.php";

    $sql = "SELECT id, naslov, slika, kategorija, sadrzaj, datum FROM vijesti WHERE id != " . $data . " ORDER BY datum DESC LIMIT 6";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='prozor'>";
            echo "<a href='vijest.php?data=" . htmlspecialchars($row["id"]) . "'>";
            echo '<img src="' . htmlspecialchars($row['slika']) . '" width="70%"/>';
            echo "<h2>" . htmlspecialchars($row["naslov"]) . "</h2>";
            echo "</a>";
            echo "</div>";
        }
    } else {
        echo "0 results";
    }

    $conn->close();
    ?>
</div>

<div class="komentari">
    <h1>Komentiraj:</h1>
    <form action="dodajkomentar.php" method="post">
            <textarea name="komentar" id="komentar" placeholder="Unesite svoj komentar ovdje" required></textarea>
            <input type="hidden" name="data" value="<?php echo isset($_GET['data']) ? htmlspecialchars($_GET['data']) : ''; ?>">
            <button type="submit">Objavi</button>
        </form>
</div>

<?php include 'komentari.php';?>

<?php include 'footer.html'; ?>

</body>
</html>
