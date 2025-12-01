<?php include "database/db.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background-color: #f5f5f5;">

<div class="container mt-4 box-shadow rounded-4 p-3 bg-white shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Student Records</h2>
        <a href="create.php" class="btn btn-success">Add Student</a>
    </div>

    <div class="d-flex justify-content-start mb-3">
        <form method="GET" class="d-flex me-2">
            <input type="text" name="search" class="form-control me-2" 
                placeholder="Search by Student ID, First Name, or Last Name" 
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <?php
    $limit = 2; // records per page
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    if ($search) {
        $count_sql = "SELECT COUNT(*) as total FROM sampcrud 
                      WHERE student_id LIKE '%$search%' 
                         OR first_name LIKE '%$search%' 
                         OR last_name LIKE '%$search%'";
    } else {
        $count_sql = "SELECT COUNT(*) as total FROM sampcrud";
    }
    $count_result = mysqli_query($conn, $count_sql);
    $total_rows = mysqli_fetch_assoc($count_result)['total'];
    $total_pages = ceil($total_rows / $limit);

    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

    // Clamp page to valid range
    if ($page < 1) $page = 1;
    if ($page > $total_pages && $total_pages > 0) $page = $total_pages;

    $offset = ($page - 1) * $limit;

    // Fetch records
    if ($search) {
        $sql = "SELECT * FROM sampcrud 
                WHERE student_id LIKE '%$search%' 
                   OR first_name LIKE '%$search%' 
                   OR last_name LIKE '%$search%' 
                ORDER BY id ASC
                LIMIT $limit OFFSET $offset";
    } else {
        $sql = "SELECT * FROM sampcrud 
                ORDER BY id ASC
                LIMIT $limit OFFSET $offset";
    }
    $result = mysqli_query($conn, $sql);
    ?>


    <table class="table table-bordered table-hover bg-white shadow-sm table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th width="140">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
        }

        while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['student_id']; ?></td>
                <td><?= $row['first_name']; ?></td>
                <td><?= $row['last_name']; ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $row['id']; ?>" 
                       onclick="return confirm('Delete this student?')"
                       class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Pagination links - Only show when NOT searching -->
    <?php if (!$search): ?>
    <nav>
      <ul class="pagination justify-content-center">
        <?php 
        $search_param = $search != '' ? 'search=' . urlencode($search) . '&' : '';

        // Previous button
        if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?<?= $search_param ?>page=<?= $page-1 ?>">Previous</a>
          </li>
        <?php endif; ?>

        <!-- Page numbers -->
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a class="page-link" href="?<?= $search_param ?>page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <!-- Next button -->
        <?php if ($page < $total_pages): ?>
          <li class="page-item">
            <a class="page-link" href="?<?= $search_param ?>page=<?= $page+1 ?>">Next</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
    <?php endif; ?>

</div>
</body>
</html>