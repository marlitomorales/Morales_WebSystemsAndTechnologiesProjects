<?php
require 'config.php';

$error = "";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


$stmt = mysqli_prepare(
    $mysqli,
    "SELECT * FROM User WHERE user_ID = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if (!$user) {
    die("User not found.");
}


$courses = [];

$result = mysqli_query(
    $mysqli,
    "SELECT * FROM Course WHERE status = 'on' ORDER BY name ASC"
);

while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = $row;
}


$selected_courses = [];

$stmt = mysqli_prepare(
    $mysqli,
    "SELECT course_ID FROM User_Course WHERE user_ID = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $selected_courses[] = $row['course_ID'];
}

mysqli_stmt_close($stmt);

if (isset($_POST['update'])) {

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $middlename = trim($_POST['middlename']);
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $email = trim($_POST['email']);

    $course_ids = $_POST['course_ids'] ?? [];


    if (
        $firstname == "" ||
        $lastname == "" ||
        $birthdate == "" ||
        $gender == "" ||
        $email == ""
    ) {

        $error = "Please complete all required fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        $stmt = mysqli_prepare(
            $mysqli,
            "SELECT user_ID FROM User
             WHERE Email = ? AND user_ID != ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $email,
            $id
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $error = "Email address is already used by another user.";
        }

        mysqli_stmt_close($stmt);
    }


    if ($error == "") {

        mysqli_begin_transaction($mysqli);

        try {
            $stmt = mysqli_prepare(
                $mysqli,
                "UPDATE User SET
                    Firstname = ?,
                    Lastname = ?,
                    Middlename = ?,
                    Birthdate = ?,
                    Gender = ?,
                    Email = ?
                 WHERE user_ID = ?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssssssi",
                $firstname,
                $lastname,
                $middlename,
                $birthdate,
                $gender,
                $email,
                $id
            );

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception(mysqli_stmt_error($stmt));
            }

            mysqli_stmt_close($stmt);


            // DELETE OLD COURSE ASSIGNMENTS
            $stmt = mysqli_prepare(
                $mysqli,
                "DELETE FROM User_Course WHERE user_ID = ?"
            );

            mysqli_stmt_bind_param($stmt, "i", $id);

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception(mysqli_stmt_error($stmt));
            }

            mysqli_stmt_close($stmt);


            // INSERT NEW COURSE ASSIGNMENTS
            if (!empty($course_ids)) {

                $stmt = mysqli_prepare(
                    $mysqli,
                    "INSERT INTO User_Course
                    (user_ID, course_ID)
                    VALUES (?, ?)"
                );

                foreach ($course_ids as $course_id) {

                    $course_id = (int)$course_id;

                    mysqli_stmt_bind_param(
                        $stmt,
                        "ii",
                        $id,
                        $course_id
                    );

                    if (!mysqli_stmt_execute($stmt)) {
                        throw new Exception(mysqli_stmt_error($stmt));
                    }

                }

                mysqli_stmt_close($stmt);

            }


            mysqli_commit($mysqli);

            header("Location: index.php");
            exit;

        } catch (Exception $e) {

            mysqli_rollback($mysqli);

            $error = "Unable to update user. " . $e->getMessage();

        }

    }

}


// DISPLAY POSTED VALUES IF THERE IS AN ERROR
if (isset($_POST['update'])) {

    $user['Firstname'] = $_POST['firstname'];
    $user['Lastname'] = $_POST['lastname'];
    $user['Middlename'] = $_POST['middlename'];
    $user['Birthdate'] = $_POST['birthdate'];
    $user['Gender'] = $_POST['gender'];
    $user['Email'] = $_POST['email'];

    $selected_courses = $_POST['course_ids'] ?? [];

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Edit User</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link href="assets/style.css" rel="stylesheet">

</head>

<body>

<div class="container py-5">

    <div class="mb-4">

        <a href="index.php"
           class="text-decoration-none">
            ← Back to Users
        </a>

        <h2 class="fw-bold mt-3">Edit User</h2>

        <p class="text-muted">
            Update user information and course assignments.
        </p>

    </div>


    <div class="card shadow-sm border-0">

        <div class="card-body p-4">

            <?php if ($error != ""): ?>

                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>


            <form method="POST">

                <h5 class="fw-bold mb-3">
                    Personal Information
                </h5>

                <div class="row g-3">

                    <div class="col-md-4">

                        <label class="form-label">Firstname *</label>

                        <input
                            type="text"
                            name="firstname"
                            class="form-control"
                            value="<?php echo htmlspecialchars($user['Firstname']); ?>"
                            required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">Middlename</label>

                        <input
                            type="text"
                            name="middlename"
                            class="form-control"
                            value="<?php echo htmlspecialchars($user['Middlename'] ?? ''); ?>">

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">Lastname *</label>

                        <input
                            type="text"
                            name="lastname"
                            class="form-control"
                            value="<?php echo htmlspecialchars($user['Lastname']); ?>"
                            required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">Birthdate *</label>

                        <input
                            type="date"
                            name="birthdate"
                            class="form-control"
                            value="<?php echo htmlspecialchars($user['Birthdate']); ?>"
                            required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">Gender *</label>

                        <select name="gender"
                                class="form-select"
                                required>

                            <option value="">Select Gender</option>

                            <option value="Male"
                                <?php if ($user['Gender'] == 'Male') echo 'selected'; ?>>
                                Male
                            </option>

                            <option value="Female"
                                <?php if ($user['Gender'] == 'Female') echo 'selected'; ?>>
                                Female
                            </option>

                        </select>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">Email *</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="<?php echo htmlspecialchars($user['Email']); ?>"
                            required>

                    </div>

                </div>


                <hr class="my-4">


                <h5 class="fw-bold mb-3">
                    Course Assignment
                </h5>


                <div class="row g-3">

                    <?php foreach ($courses as $c): ?>

                        <div class="col-md-6">

                            <div class="form-check border rounded p-3 ps-5">

                                <input
                                    type="checkbox"
                                    name="course_ids[]"
                                    value="<?php echo $c['Course_ID']; ?>"
                                    class="form-check-input"
                                    id="course<?php echo $c['Course_ID']; ?>"
                                    <?php
                                    if (in_array(
                                        $c['Course_ID'],
                                        $selected_courses
                                    )) echo 'checked';
                                    ?>>

                                <label
                                    class="form-check-label fw-semibold"
                                    for="course<?php echo $c['Course_ID']; ?>">

                                    <?php echo htmlspecialchars($c['name']); ?>

                                    <span class="text-muted small d-block">
                                        <?php echo htmlspecialchars($c['course_code']); ?>
                                    </span>

                                </label>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>


                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="index.php"
                       class="btn btn-light border">
                        Cancel
                    </a>

                    <button type="submit"
                            name="update"
                            class="btn btn-primary">
                        Update User
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>