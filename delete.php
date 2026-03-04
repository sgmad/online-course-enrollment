<?php
include 'db.php';

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    
    $sql = "DELETE FROM student WHERE StudentId = '$student_id'";
    mysqli_query($conn, $sql);

    header("Location: index.php");
}
?>

