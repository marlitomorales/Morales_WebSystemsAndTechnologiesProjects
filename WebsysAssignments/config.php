<?php

$mysqli = mysqli_connect(
    "localhost",
    "root",
    "",
    "user_course_db"
);

if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}

?>