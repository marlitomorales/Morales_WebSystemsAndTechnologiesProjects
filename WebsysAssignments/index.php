<?php
require 'config.php';

$users = [];

$where = [];
$params = [];
$types = "";

if (!empty($_GET['keyword'])) {

    $keyword = "%" . $_GET['keyword'] . "%";

    $where[] = "(
        u.Firstname LIKE ?
        OR u.Lastname LIKE ?
        OR u.Middlename LIKE ?
        OR EXISTS (
            SELECT 1
            FROM User_Course uc2
            INNER JOIN Course c2
                ON uc2.course_ID = c2.Course_ID
            WHERE uc2.user_ID = u.user_ID
            AND (
                c2.description LIKE ?
                OR c2.course_code LIKE ?
            )
        )
    )";

    $params[] = $keyword;
    $params[] = $keyword;
    $params[] = $keyword;
    $params[] = $keyword;
    $params[] = $keyword;

    $types .= "sssss";
}

if (!empty($_GET['gender'])) {

    $where[] = "u.Gender = ?";

    $params[] = $_GET['gender'];

    $types .= "s";
}

if (!empty($_GET['from'])) {

    $where[] = "u.Date_Created >= ?";

    $params[] = $_GET['from'] . " 00:00:00";

    $types .= "s";
}

if (!empty($_GET['to'])) {

    $where[] = "u.Date_Created < DATE_ADD(?, INTERVAL 1 DAY)";

    $params[] = $_GET['to'];

    $types .= "s";
}

$sql = "
    SELECT
        u.user_ID,
        u.Firstname,
        u.Lastname,
        u.Middlename,
        u.Birthdate,
        u.Gender,
        u.Email,
        u.Date_Created,

        GROUP_CONCAT(
            DISTINCT CONCAT(
                c.course_code,
                ' - ',
                c.name,
                ' (',
                c.status,
                ')'
            )
            ORDER BY c.course_code
            SEPARATOR '<br>'
        ) AS courses

    FROM User u

    LEFT JOIN User_Course uc
        ON u.user_ID = uc.user_ID

    LEFT JOIN Course c
        ON uc.course_ID = c.Course_ID
";

if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= "
    GROUP BY u.user_ID
    ORDER BY u.user_ID DESC
";

$stmt = mysqli_prepare($mysqli, $sql);

if (!$stmt) {
    die("Query error: " . mysqli_error($mysqli));
}

if (count($params) > 0) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

mysqli_stmt_close($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>User Management System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="assets/style.css"
        rel="stylesheet">

</head>

<body>

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between
                align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">User Management</h2>

            <p class="text-muted mb-0">
                Manage registered users and their courses.
            </p>
        </div>

        <a href="create.php" class="btn btn-primary">
            + Add User
        </a>

    </div>

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3 align-items-end">

                    <div class="col-lg-4">

                        <label class="form-label">
                            Keyword Search
                        </label>

                        <input
                            type="text"
                            name="keyword"
                            class="form-control"
                            placeholder="Search name or course..."
                            value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">

                    </div>


                    <div class="col-lg-2">

                        <label class="form-label">
                            Gender
                        </label>

                        <select name="gender"
                                class="form-select">

                            <option value="">All Gender</option>

                            <option value="Male"
                                <?php if (($_GET['gender'] ?? '') == 'Male') echo 'selected'; ?>>
                                Male
                            </option>

                            <option value="Female"
                                <?php if (($_GET['gender'] ?? '') == 'Female') echo 'selected'; ?>>
                                Female
                            </option>

                        </select>

                    </div>


                    <div class="col-lg-2">

                        <label class="form-label">
                            From
                        </label>

                        <input
                            type="date"
                            name="from"
                            class="form-control"
                            value="<?php echo htmlspecialchars($_GET['from'] ?? ''); ?>">

                    </div>


                    <div class="col-lg-2">

                        <label class="form-label">
                            To
                        </label>

                        <input
                            type="date"
                            name="to"
                            class="form-control"
                            value="<?php echo htmlspecialchars($_GET['to'] ?? ''); ?>">

                    </div>


                    <div class="col-lg-2 d-flex gap-2">

                        <button type="submit"
                                class="btn btn-primary w-100">
                            Search
                        </button>

                        <a href="index.php"
                           class="btn btn-outline-secondary">
                            Reset
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- USER TABLE -->
    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">

                <h5 class="fw-bold">
                    Registered Users
                </h5>

                <span class="text-muted">
                    Total: <?php echo count($users); ?> users
                </span>

            </div>


            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Birthdate</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Courses</th>
                            <th>Date Created</th>
                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if (count($users) > 0): ?>

                        <?php foreach ($users as $u): ?>

                            <tr>

                                <td>
                                    <?php echo htmlspecialchars($u['user_ID']); ?>
                                </td>


                                <td class="fw-semibold">

                                    <?php

                                    echo htmlspecialchars(
                                        $u['Firstname'] . " " .
                                        $u['Middlename'] . " " .
                                        $u['Lastname']
                                    );

                                    ?>

                                </td>


                                <td>
                                    <?php echo htmlspecialchars($u['Birthdate']); ?>
                                </td>


                                <td>
                                    <?php echo htmlspecialchars($u['Gender']); ?>
                                </td>


                                <td>
                                    <?php echo htmlspecialchars($u['Email']); ?>
                                </td>


                                <td>

                                    <?php

                                    if (!empty($u['courses'])) {

                                        echo $u['courses'];

                                    } else {

                                        echo '<span class="text-muted">No courses assigned</span>';

                                    }

                                    ?>

                                </td>


                                <td>
                                    <?php echo htmlspecialchars($u['Date_Created']); ?>
                                </td>


                                <td>

                                    <div class="d-flex gap-2">

                                        <a
                                            href="edit.php?id=<?php echo $u['user_ID']; ?>"
                                            class="btn btn-sm btn-warning">

                                            Edit

                                        </a>


                                        <a
                                            href="delete.php?id=<?php echo $u['user_ID']; ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this user?');">

                                            Delete

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="8"
                                class="text-center py-5 text-muted">

                                No users found.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>