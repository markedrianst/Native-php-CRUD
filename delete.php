<?php
include "database/db.php";
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM sampcrud WHERE id=$id");

header("Location: index.php");
?>
