<?php
require 'config.php';

$error = "";

$courses = [];

$result = mysqli_query(
    $mysqli,
    "SELECT * FROM Course WHERE status = 'on' ORDER BY name ASC"
);

while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = $row;
}


if (isset($_POST['save'])) {

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

       
        $check = mysqli_prepare(
            $mysqli,
            "SELECT user_ID FROM User WHERE Email = ?"
        );

        mysqli_stmt_bind_param($check, "s", $email);

        mysqli_stmt_execute($check);

        $existing = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($existing) > 0) {

            $error = "Email address already exists!";

        }

        mysqli_stmt_close($check);
    }


    if ($error == "") {

        mysqli_begin_transaction($mysqli);

        try {

            $stmt = mysqli_prepare(
                $mysqli,
                "INSERT INTO User
                (Firstname, Lastname, Middlename, Birthdate, Gender, Email)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssssss",
                $firstname,
                $lastname,
                $middlename,
                $birthdate,
                $gender,
                $email
            );

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception(mysqli_stmt_error($stmt));
            }

            $user_id = mysqli_insert_id($mysqli);

            mysqli_stmt_close($stmt);

            if (!empty($course_ids)) {

                $stmt = mysqli_prepare(
                    $mysqli,
                    "INSERT INTO User_Course (user_ID, course_ID)
                     VALUES (?, ?)"
                );

                foreach ($course_ids as $course_id) {

                    $course_id = (int)$course_id;

                    mysqli_stmt_bind_param(
                        $stmt,
                        "ii",
                        $user_id,
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

            $error = "Unable to save user. " . $e->getMessage();

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Add User</title>

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

        <h2 class="fw-bold mt-3">Add New User</h2>

        <p class="text-muted">
            Enter the user's information and assign courses.
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
                            value="<?php echo htmlspecialchars($_POST['firstname'] ?? ''); ?>"
                            required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">Middlename</label>

                        <input
                            type="text"
                            name="middlename"
                            class="form-control"
                            value="<?php echo htmlspecialchars($_POST['middlename'] ?? ''); ?>">

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">Lastname *</label>

                        <input
                            type="text"
                            name="lastname"
                            class="form-control"
                            value="<?php echo htmlspecialchars($_POST['lastname'] ?? ''); ?>"
                            required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">Birthdate *</label>

                        <input
                            type="date"
                            name="birthdate"
                            class="form-control"
                            value="<?php echo htmlspecialchars($_POST['birthdate'] ?? ''); ?>"
                            required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">Gender *</label>

                        <select name="gender"
                                class="form-select"
                                required>

                            <option value="">Select Gender</option>

                            <option value="Male"
                                <?php if (($_POST['gender'] ?? '') == 'Male') echo 'selected'; ?>>
                                Male
                            </option>

                            <option value="Female"
                                <?php if (($_POST['gender'] ?? '') == 'Female') echo 'selected'; ?>>
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
                            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                            required>

                    </div>

                </div>


                <hr class="my-4">


                <h5 class="fw-bold mb-3">
                    Course Assignment
                </h5>

                <p class="text-muted small">
                    Select the courses assigned to this user.
                </p>


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
                                        $_POST['course_ids'] ?? []
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
                            name="save"
                            class="btn btn-primary">
                        Save User
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>