<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $course_name = $_POST['course_name'];
    $enrollment_date = $_POST['enrollment_date'];

    $sql1 = "UPDATE student SET FirstName='$first_name', LastName='$last_name', Email='$email' WHERE StudentId='$student_id'";
    mysqli_query($conn, $sql1);

    $sql2 = "UPDATE enrollment SET CourseName='$course_name', EnrollmentDate='$enrollment_date' WHERE StudentId='$student_id'";
    mysqli_query($conn, $sql2);

    header("Location: index.php");
}
?>

