<?php
$conn = mysqli_connect("localhost", "root", "", "simple-crud");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
