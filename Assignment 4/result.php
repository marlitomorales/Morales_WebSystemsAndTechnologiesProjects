<?php

$name = trim($_GET['FullName'] ?? '');
$age = trim($_GET['age'] ?? '');
$contact = trim($_GET['contact'] ?? '');
$email = trim($_GET['email'] ?? '');
$address = trim($_GET['address'] ?? '');
$program = trim($_GET['program'] ?? '');
$objective = trim($_GET['objective'] ?? '');
$skills = trim($_GET['skills'] ?? '');
$softskills = trim($_GET['softskills'] ?? '');
$experiences = trim($_GET['experiences'] ?? '');
$certifications = trim($_GET['certifications'] ?? '');
$languages = trim($_GET['languages'] ?? '');
$projects = trim($_GET['projects'] ?? '');

$error = false;

if ($name == '') {
    $errorFullName = "Full Name is required.";
    $error = true;
}

if ($age == '') {
    $errorAge = "Age is required.";
    $error = true;
} elseif (!is_numeric($age)) {
    $errorAge = "Age must be a number.";
    $error = true;
}

if ($contact == '') {
    $errorContact = "Contact Number is required.";
    $error = true;
} elseif (!preg_match('/^[0-9]{11}$/', $contact)) {
    $errorContact = "Contact Number must be exactly 11 digits.";
    $error = true;
}

if ($email == '') {
    $errorEmail = "Email is required.";
    $error = true;
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorEmail = "Please enter a valid email address.";
    $error = true;
}

if ($address == '') {
    $errorAddress = "Address is required.";
    $error = true;
}

if ($program == '') {
    $errorProgram = "Please select your program.";
    $error = true;
}

if ($objective == '') {
    $errorObjective = "Career Objective is required.";
    $error = true;
}
if ($skills == '') {
    $errorSkills = "Technical Skills are required.";
    $error = true;
}

if ($softskills == '') {
    $errorSoftskills = "Soft Skills are required.";
    $error = true;
}

if ($experiences == '') {
    $errorExperiences = "Work Experience is required.";
    $error = true;
}

if ($certifications == '') {
    $errorCertifications = "Certifications are required.";
    $error = true;
}

if ($languages == '') {
    $errorLanguages = "Languages are required.";
    $error = true;
}

if ($projects == '') {
    $errorProjects = "Projects or Internships are required.";
    $error = true;
}

if ($error) {
    include "index.php";
    exit;
}
$name = htmlspecialchars($name);
$age = htmlspecialchars($age);
$contact = htmlspecialchars($contact);
$email = htmlspecialchars($email);
$address = htmlspecialchars($address);
$program = htmlspecialchars($program);
$objective = htmlspecialchars($objective);
$skills = htmlspecialchars($skills);
$softskills = htmlspecialchars($softskills);
$experiences = htmlspecialchars($experiences);
$certifications = htmlspecialchars($certifications);
$languages = htmlspecialchars($languages);
$projects = htmlspecialchars($projects);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Resume</title>

    <link rel="stylesheet" href="style.css">

</head>

<body class="resume-page">

    <div class="resume">
        <div class="resume-header">

            <h1>
                <?php echo $name; ?>
            </h1>

        </div>


        <div class="resume-content">
            <div class="sidebar">

                <section>

                    <h2>CONTACT</h2>

                    <p>
                        <strong>Age:</strong>
                        <?php echo $age; ?>
                    </p>

                    <p>
                        <strong>Phone:</strong>
                        <?php echo $contact; ?>
                    </p>

                    <p>
                        <strong>Email:</strong>
                        <?php echo $email; ?>
                    </p>

                    <p>
                        <strong>Address:</strong>
                        <?php echo $address; ?>
                    </p>

                </section>


                <section>

                    <h2>EDUCATION</h2>

                    <p>
                        <?php echo $program; ?>
                    </p>

                </section>

                <section>

                    <h2>SKILLS</h2>

                    <p>
                        <?php echo $skills; ?>
                    </p>

                </section>


                <section>

                    <h2>SOFT SKILLS</h2>

                    <p>
                        <?php echo $softskills; ?>
                    </p>

                </section>


                <section>

                    <h2>LANGUAGES</h2>

                    <p>
                        <?php echo $languages; ?>
                    </p>

                </section>

            </div>
            <div class="main-content">
                <div class="resume-section">

                    <div class="section-title">

                        <div class="timeline-circle"></div>

                        <h2>CAREER OBJECTIVE</h2>

                    </div>

                    <p>
                        <?php echo $objective; ?>
                    </p>

                </div>
                <div class="resume-section">

                    <div class="section-title">

                        <div class="timeline-circle"></div>

                        <h2>WORK EXPERIENCE</h2>

                    </div>

                    <p>
                        <?php echo $experiences; ?>
                    </p>

                </div>
                <div class="resume-section">

                    <div class="section-title">

                        <div class="timeline-circle"></div>

                        <h2>CERTIFICATIONS</h2>

                    </div>

                    <p>
                        <?php echo $certifications; ?>
                    </p>

                </div>
                <div class="resume-section">

                    <div class="section-title">

                        <div class="timeline-circle"></div>

                        <h2>PROJECTS / INTERNSHIPS</h2>

                    </div>

                    <p>
                        <?php echo $projects; ?>
                    </p>

                </div>


            </div>

        </div>
         <?php if ($email != ''): ?>

    <p class="resume-footer">
        <?php echo $email; ?>. All rights reserved
    </p>

    <?php endif; ?>
    </div>

</body>

</html>