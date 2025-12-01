<?php include "database/db.php"; ?>

<?php
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM sampcrud WHERE id=$id"));

if (isset($_POST['update'])) {
    $student_id = $_POST['student_id'];
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];

    mysqli_query($conn, "UPDATE sampcrud 
                         SET student_id='$student_id', first_name='$first', last_name='$last'
                         WHERE id=$id");

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-primary mb-3">Edit Student</h2>

    <form method="POST" class="card p-4 shadow-sm bg-white">
        <div class="mb-3">
            <label>Student ID</label>
            <input type="text" name="student_id" class="form-control" value="<?= $data['student_id']; ?>" required>
        </div>

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="<?= $data['first_name']; ?>" required>
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="<?= $data['last_name']; ?>" required>
        </div>

        <button class="btn btn-primary mb-3" name="update">Update</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>

</div>
</body>
</html>
