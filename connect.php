<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "vijesti";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Neuspješno povezivanje na bazu podataka: " . $conn->connect_error);
}

?>