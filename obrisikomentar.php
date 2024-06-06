<?php
include "connect.php";

session_start();
if(isset($_GET['id'])) {
    $comment_id = $_GET['id'];
    
    $sql_delete = "DELETE FROM komentar WHERE id = $comment_id";
    
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        echo "Error deleting comment: " . $conn->error;
    }
} else {
    header("Location: index.php");
    exit();
}
?>
