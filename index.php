<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon-32x32.png">
    <title>Newsweek</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <section>

    <?php 
        
    $data = isset($_GET['data']) ? $_GET['data'] : '';

    include "connect.php";

    if (basename($_SERVER['PHP_SELF']) == "index.php" && empty($data)) {
        header("Location: index.php?data=home");
        exit();
    }

    if ($data === 'home') {
        $sql = "SELECT id, naslov, slika, kategorija, sadrzaj FROM vijesti ORDER BY datum DESC";
    } else {
        $sql = "SELECT id, naslov, slika, kategorija FROM vijesti WHERE kategorija='" . $conn->real_escape_string($data) . "' ORDER BY datum DESC";
    }

    $result = $conn->query($sql);

    if ($data === 'home'){
        echo '<div class="naslov">Home</div>';
    }
    else {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="naslov">' . htmlspecialchars($row["kategorija"]) . '</div>';
            break;
        }
    }

    $result = $conn->query($sql);
    echo "<div class=grid>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<article>";
            echo "<a href='vijest.php?data=" . htmlspecialchars($row["id"]) . "'>";
            echo '<img src="' . htmlspecialchars($row['slika']) . '" width="70%"/>';
            echo "<h2>" . htmlspecialchars($row["naslov"]) . "</h2>";
            echo "</a>";
            echo "</article>";
        }
    } else {
        echo "0 results";
    }
    echo "</div>";

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->close();
    ?>

    </section>

    <?php include 'footer.html'; ?>
</body>
</html>
