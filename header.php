<header>
    <p id="datetime"></p>
    <h1>Newsweek</h1>

    <?php
        if (session_status() == 1) {
            session_start();
        }
        
        $username = "Prijava";

        if (isset($_SESSION['user_id'])) {
            include "connect.php";
            $user_id = $_SESSION['user_id'];

            $sql = "SELECT user FROM korisnik WHERE id='$user_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $username = $row['user'];
                if($username == 'root') {
                    $username = "Prijava";
                }
            }
        }
    ?>

    <nav>
        <ul>
            <li><a href="index.php?data=home">Home</a></li>
            <li><a href="index.php?data=U.S.">U.S.</a></li>
            <li><a href="index.php?data=world">World</a></li>
            <li><a href="prijavasite.php"><?php echo $username; ?></a></li>
        </ul>
    </nav>
</header>
<hr class="line">
