<?php include "database/db.php"; ?>

<?php
if (isset($_POST['save'])) {
    $student_id = $_POST['student_id'];
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];

    mysqli_query($conn, "INSERT INTO sampcrud (student_id, first_name, last_name)
                         VALUES ('$student_id', '$first', '$last')");

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-primary mb-3">Add Student</h2>

    <form method="POST" class="card p-4 shadow-sm bg-white">
        <div class="mb-3">
            <label>Student ID</label>
            <input type="text" name="student_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>

        <button class="btn btn-primary mb-3" name="save">Save</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>

</div>
</body>
</html>
