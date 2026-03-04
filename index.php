<?php
include 'db.php';

$edit_fname = "";
$edit_lname = "";
$edit_email = "";
$edit_course = "";
$edit_date = "";
$edit_id = "";
$form_action = "create.php";
$btn_text = "Complete Enrollment";

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_query = "SELECT * FROM student INNER JOIN enrollment ON student.StudentId = enrollment.StudentId WHERE student.StudentId = '$id'";
    $edit_result = mysqli_query($conn, $edit_query);
    
    if ($row = mysqli_fetch_assoc($edit_result)) {
        $edit_fname = $row['FirstName'];
        $edit_lname = $row['LastName'];
        $edit_email = $row['Email'];
        $edit_course = $row['CourseName'];
        $edit_date = $row['EnrollmentDate'];
        $edit_id = $row['StudentId'];
        $form_action = "update.php";
        $btn_text = "Update Enrollment";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Course Enrollment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: sans-serif; }
        .form-control { background-color: transparent; border: none; border-bottom: 1px solid #ddd; border-radius: 0; padding-left: 0; }
        .form-control:focus { box-shadow: none; background-color: transparent; border-bottom: 2px solid #0d6efd; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 pe-5">
            <h4 class="mb-4">🎓 Enroll Student</h4>
            
            <form action="<?php echo $form_action; ?>" method="POST">
                <input type="hidden" name="student_id" value="<?php echo $edit_id; ?>">
                
                <div class="mb-4">
                    <label class="fw-bold text-dark" style="font-size: 13px;">First Name</label>
                    <input type="text" name="first_name" class="form-control" placeholder="John" value="<?php echo $edit_fname; ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="fw-bold text-dark" style="font-size: 13px;">Last Name</label>
                    <input type="text" name="last_name" class="form-control" placeholder="Doe" value="<?php echo $edit_lname; ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="fw-bold text-dark" style="font-size: 13px;">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="name@example.com" value="<?php echo $edit_email; ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="fw-bold text-dark" style="font-size: 13px;">Course Name</label>
                    <input type="text" name="course_name" class="form-control" placeholder="e.g. Computer Science" value="<?php echo $edit_course; ?>" required>
                </div>
                
                <div class="mb-5">
                    <label class="fw-bold text-dark" style="font-size: 13px;">Enrollment Date</label>
                    <input type="date" name="enrollment_date" class="form-control" value="<?php echo $edit_date; ?>" required>
                </div>
                
                <button type="submit" name="submit" class="btn btn-primary w-100 rounded-3 py-2"><?php echo $btn_text; ?></button>
            </form>
        </div>
        
        <div class="col-md-8 ps-5">
            <table class="table table-borderless">
                <thead>
                    <tr class="text-dark fw-bold" style="font-size: 14px;">
                        <th>Name</th>
                        <th>Course</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT student.StudentId, student.FirstName, student.LastName, student.Email, enrollment.CourseName, enrollment.EnrollmentDate 
                            FROM student 
                            INNER JOIN enrollment ON student.StudentId = enrollment.StudentId";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $date = date("M d, Y", strtotime($row['EnrollmentDate']));
                        echo "<tr>";
                        echo "<td class='py-3'>
                                <div class='fw-bold text-uppercase' style='font-size: 14px;'>" . $row['FirstName'] . " " . $row['LastName'] . "</div>
                                <div class='text-muted' style='font-size: 13px;'>" . $row['Email'] . "</div>
                              </td>";
                        echo "<td class='py-3'><span class='badge bg-info text-white px-3 py-1 rounded-pill' style='font-size: 12px;'>" . $row['CourseName'] . "</span></td>";
                        echo "<td class='py-3'><span class='text-muted' style='font-size: 13px;'>" . $date . "</span></td>";
                        echo "<td class='py-3' style='font-size: 13px;'>
                                <a href='index.php?edit=" . $row['StudentId'] . "' class='text-primary text-decoration-none me-3'>Edit</a>
                                <a href='delete.php?id=" . $row['StudentId'] . "' class='text-danger text-decoration-none'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
