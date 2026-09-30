
<?php

if (isset($_POST["upload"])) {

    $file_name = basename($_FILES["myfile"]["name"]);
    $file_size = $_FILES["myfile"]["size"];
    $file_tmp = $_FILES["myfile"]["tmp_name"];


    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $max_size = 300 * 1024 * 1024;
    $allowed_types = ["xls", "xlsx"];

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    if (!in_array($file_type, $allowed_types)) {

        echo "<script>
                alert('Error: Only Excel files (.xls or .xlsx) are allowed.');
                window.location.href='index.php';
              </script>";

    }

    else if ($file_size > $max_size) {

        echo "<script>
                alert('Error: File is too large. Maximum file size is 300 MB.');
                window.location.href='index.php';
              </script>";

    }

    else {

        $target_file = "uploads/" . $file_name;

        if (move_uploaded_file($file_tmp, $target_file)) {

            echo "<script>
                    alert('Excel file uploaded successfully!');
                    window.location.href='index.php';
                  </script>";

        } else {

            echo "<script>
                    alert('Error: There was a problem uploading the file.');
                    window.location.href='index.php';
                  </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Excel File Upload</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
            padding-top: 100px;
        }

        .container {
            background-color: white;
            width: 450px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gray;
        }

        h2 {
            color: #333;
        }

        input[type="file"] {
            margin: 20px;
            padding: 10px;
        }

        button {
            background-color: #217346;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #185c37;
        }

        p {
            color: gray;
        }

    </style>

</head>

<body>

    <div class="container">

        <h2>Upload Excel File</h2>

        <p>Only .xls and .xlsx files are allowed.</p>
        <p>Maximum file size: 300 MB</p>

        <form action="" method="POST" enctype="multipart/form-data">

            <input type="file" name="myfile" accept=".xls,.xlsx" required>

            <br>

            <button type="submit" name="upload">
                Upload Excel File
            </button>

        </form>

    </div>

</body>
</html>
