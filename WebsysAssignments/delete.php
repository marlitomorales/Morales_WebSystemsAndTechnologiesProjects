<?php
require 'config.php';

if (isset($_GET['id'])) {

    $id = (int)$_GET['id'];

    $stmt = mysqli_prepare(
        $mysqli,
        "DELETE FROM User WHERE user_ID = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {

        header("Location: index.php");
        exit;

    } else {

        die("Delete error: " . mysqli_stmt_error($stmt));

    }

    mysqli_stmt_close($stmt);

} else {

    header("Location: index.php");
    exit;

}

?>