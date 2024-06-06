<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsweek
    </title>
    <link rel="stylesheet" href="administracijastyle.css">
    <link rel="icon" type="image/x-icon" href="favicon-32x32.png">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <?php
include "connect.php";


if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_level']) || $_SESSION['user_level'] == 0) {
    header("Location: prijavasite.php");
    exit();
}

$local_mac_address = $_SERVER['REMOTE_ADDR'];
$found_user = false;
?>


    <section role="main">
    <form action="" method="post">
        <button type="submit" name="odjava">Logout</button>
     </form>
         <?php
        if(isset($_POST['odjava'])) {
            session_unset();
            session_destroy();
            header("Location: index.php?data=home");
            exit();
        }
        ?>
        <h1>Unos vijesti</h1>
        <form action="administracija.php" method="POST" enctype="multipart/form-data">
            <div class="form-item">
                <label for="naslov">Naslov:</label>
                <input type="text" name="naslov" id="naslov">
            </div>
            <div class="form-item">
                <label class="sadrzaj" for="sadrzaj">Sadržaj:</label>
                <textarea name="sadrzaj" id="sadrzaj" rows="4" cols="50"></textarea>
            </div>

            <div class="form-item">
                <label for="slika">Slika:</label>
                <input type="file" name="slika" id="slika">
            </div>

            
            <div class="form-item">
    <label for="kategorija">Kategorija:</label>
    <select name="kategorija" id="kategorija">
        <option value="U.S.">U.S</option>
        <option value="World">World</option>
        <option value="Europe">Europe</option>
        <option value="custom">Custom</option>
    </select>
</div>
<div id="custom_category_input" style="display: none;">
    <div class="form-item">
        <label for="custom_kategorija">Custom kategorija:</label>
        <input type="text" name="custom_kategorija" id="custom_kategorija">
    </div>
</div>
<script>
    document.getElementById('kategorija').addEventListener('change', function() {
        var selectBox = document.getElementById('kategorija');
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;
        if (selectedValue === 'custom') {
            document.getElementById('custom_category_input').style.display = 'block';
        } else {
            document.getElementById('custom_category_input').style.display = 'none';
        }
    });
</script>

            <div class="buttons">
                <button type="reset">Poništi</button>
                <button type="submit">Prihvati</button>
            </div>
        </form>
<h1>Brisanje vijesti</h1>
<form action="obrisi.php" method="POST">
    <div class="form-item">
        <label for="delete_title">Naslov vijesti za brisanje:</label>
        <input type="text" name="delete_title" id="delete_title">
    </div>
    <div class="buttons">
        <button type="submit">Obriši</button>
    </div>
</form>
<script>
        CKEDITOR.replace( 'sadrzaj' );
</script>
    </section>
    <?php 
    if(isset($_POST['nova_kategorija']) && !empty($_POST['nova_kategorija'])) {
        $nova_kategorija = $_POST['nova_kategorija'];
        $query = "INSERT INTO kategorije (naziv) VALUES ('$nova_kategorija')";
        if(mysqli_query($conn, $query)) {
            echo "<p>Nova kategorija uspješno dodana.</p>";
        } else {
            echo "<p>Greška prilikom dodavanja nove kategorije: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>
    <?php include 'footer.html'; ?>
</body>
</html>