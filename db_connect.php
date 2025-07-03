<?php
    $DBConnect = mysqli_connect("localhost", "root", "", "eduassist");
    if (mysqli_connect_errno()) {
        die("Database connection failed: " . mysqli_connect_error());
    }
?>