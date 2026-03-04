
<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt1 = $conn->prepare("INSERT INTO student (FirstName, LastName, Email) VALUES (?, ?, ?)");
    $stmt1->bind_param("sss", $_POST['first_name'], $_POST['last_name'], $_POST['email']);
    $stmt1->execute();
    $student_id = $conn->insert_id;
    $stmt1->close();

    $stmt2 = $conn->prepare("INSERT INTO enrollment (StudentId, CourseName, EnrollmentDate) VALUES (?, ?, ?)");
    $stmt2->bind_param("iss", $student_id, $_POST['course_name'], $_POST['enrollment_date']);
    $stmt2->execute();
    $stmt2->close();
    
    header("Location: index.php");
    exit();
}
?>
