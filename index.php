<?php
require 'db.php';

$edit_data = null;
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT s.*, e.CourseName, e.EnrollmentDate FROM student s JOIN enrollment e ON s.StudentId = e.StudentId WHERE s.StudentId=?");
    $stmt->bind_param("i", $_GET['edit']);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_data = $result->fetch_assoc();
    $stmt->close();
}

$sql = "SELECT s.StudentId, s.FirstName, s.LastName, s.Email, e.CourseName, e.EnrollmentDate FROM student s JOIN enrollment e ON s.StudentId = e.StudentId";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Course Enrollment System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background-color: #f8f9fa; }
    .table-borderless > tbody > tr > td, .table-borderless > thead > tr > th { border: none; }
</style>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 pe-5">
            <h5 class="mb-4">🎓 Enroll Student</h5>
            <form method="POST" action="<?= $edit_data ? 'update.php' : 'create.php' ?>">
                <?php if ($edit_data): ?>
                    <input type="hidden" name="student_id" value="<?= $edit_data['StudentId'] ?>">
                <?php endif; ?>
                
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">First Name</label>
                    <input type="text" name="first_name" class="form-control bg-light border-0" value="<?= $edit_data['FirstName'] ?? '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Last Name</label>
                    <input type="text" name="last_name" class="form-control bg-light border-0" value="<?= $edit_data['LastName'] ?? '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Email Address</label>
                    <input type="email" name="email" class="form-control bg-light border-0" value="<?= $edit_data['Email'] ?? '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Course Name</label>
                    <input type="text" name="course_name" class="form-control bg-light border-0" value="<?= $edit_data['CourseName'] ?? '' ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold">Enrollment Date</label>
                    <input type="date" name="enrollment_date" class="form-control bg-light border-0" value="<?= $edit_data['EnrollmentDate'] ?? '' ?>" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 rounded-3"><?= $edit_data ? 'Update Enrollment' : 'Complete Enrollment' ?></button>
            </form>
        </div>
        <div class="col-md-8 ps-5">
            <table class="table table-borderless mt-2">
                <thead>
                    <tr class="text-muted small fw-bold">
                        <th>Name</th>
                        <th>Course</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="pt-3">
                            <span class="text-uppercase fw-bold text-dark d-block"><?= htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']) ?></span>
                            <small class="text-muted"><?= htmlspecialchars($row['Email']) ?></small>
                        </td>
                        <td class="pt-3 align-middle">
                            <span class="badge bg-info text-light rounded-pill px-3 py-2"><?= htmlspecialchars($row['CourseName']) ?></span>
                        </td>
                        <td class="pt-3 align-middle text-muted small">
                            <?= htmlspecialchars(date('M d, Y', strtotime($row['EnrollmentDate']))) ?>
                        </td>
                        <td class="pt-3 align-middle">
                            <a href="?edit=<?= $row['StudentId'] ?>" class="text-primary text-decoration-none small fw-bold me-3">Edit</a>
                            <a href="delete.php?id=<?= $row['StudentId'] ?>" class="text-danger text-decoration-none small fw-bold" onclick="return confirm('Confirm deletion')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>

