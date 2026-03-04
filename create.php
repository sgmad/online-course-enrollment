<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $course_name = $_POST['course_name'];
    $enrollment_date = $_POST['enrollment_date'];

    $sql1 = "INSERT INTO student (FirstName, LastName, Email) VALUES ('$first_name', '$last_name', '$email')";
    mysqli_query($conn, $sql1);
    
    $student_id = mysqli_insert_id($conn);

    $sql2 = "INSERT INTO enrollment (StudentId, CourseName, EnrollmentDate) VALUES ('$student_id', '$course_name', '$enrollment_date')";
    mysqli_query($conn, $sql2);

    header("Location: index.php");
}
?>
