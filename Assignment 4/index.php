<?php
// Get old values so they stay in the form after an error
$FullName = $_GET['FullName'] ?? '';
$age = $_GET['age'] ?? '';
$contact = $_GET['contact'] ?? '';
$email = $_GET['email'] ?? '';
$address = $_GET['address'] ?? '';
$program = $_GET['program'] ?? '';
$objective = $_GET['objective'] ?? '';
$skills = $_GET['skills'] ?? '';
$softskills = $_GET['softskills'] ?? '';
$experiences = $_GET['experiences'] ?? '';
$certifications = $_GET['certifications'] ?? '';
$languages = $_GET['languages'] ?? '';
$projects = $_GET['projects'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Builder</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="form-page">

<div class="form-container">

    <h1>Resume Builder</h1>

    <p class="form-description">
        Enter your information below to create your resume.
    </p>

    <form action="result.php" method="get">

        <h2>Personal Information</h2>

        <label for="FullName">Full Name</label>

        <input
            type="text"
            id="FullName"
            name="FullName"
            value="<?php echo htmlspecialchars($FullName); ?>"
            placeholder="Enter your full name"
        >

       <?php if (isset($errorFullName)): ?>
        <span class="error"><?php echo $errorFullName; ?></span>
        <?php endif; ?>


        <label for="age">Age</label>

        <input
            type="number"
            id="age"
            name="age"
            value="<?php echo htmlspecialchars($age); ?>"
            placeholder="Enter your age"
        >

       <?php if (isset($errorAge)): ?>
        <span class="error"><?php echo $errorAge; ?></span>
        <?php endif; ?>


        <label for="contact">Contact Number</label>

        <input
            type="text"
            id="contact"
            name="contact"
            value="<?php echo htmlspecialchars($contact); ?>"
            placeholder="Enter your contact number"
        >

        <?php if (isset($errorContact)): ?>
        <span class="error"><?php echo $errorContact; ?></span>
        <?php endif; ?>


        <label for="email">Email</label>

        <input
            type="text"
            id="email"
            name="email"
            value="<?php echo htmlspecialchars($email); ?>"
            placeholder="Enter your email"
        >

        <?php if (isset($errorEmail)): ?>
        <span class="error"><?php echo $errorEmail; ?></span>
        <?php endif; ?>


        <label for="address">Address</label>

        <input
            type="text"
            id="address"
            name="address"
            value="<?php echo htmlspecialchars($address); ?>"
            placeholder="Enter your address"
        >

       <?php if (isset($errorAddress)): ?>
        <span class="error"><?php echo $errorAddress; ?></span>
        <?php endif; ?>


        <h2>Career Information</h2>

        <label for="program">Education / Program</label>

        <select name="program" id="program">

            <option value="">Select your program</option>

            <option value="Bachelor of Science in Information Technology"
                <?php if ($program == "Bachelor of Science in Information Technology") echo "selected"; ?>>
                Bachelor of Science in Information Technology
            </option>

            <option value="Bachelor of Science in Computer Science"
                <?php if ($program == "Bachelor of Science in Computer Science") echo "selected"; ?>>
                Bachelor of Science in Computer Science
            </option>

            <option value="Bachelor of Science in Civil Engineering"
                <?php if ($program == "Bachelor of Science in Civil Engineering") echo "selected"; ?>>
                Bachelor of Science in Civil Engineering
            </option>

        </select>

       <?php if (isset($errorProgram)): ?>
        <span class="error"><?php echo $errorProgram; ?></span>
        <?php endif; ?>


        <label for="objective">Career Objective</label>

        <textarea
            name="objective"
            id="objective"
            rows="4"
            placeholder="Enter your career objective"
        ><?php echo htmlspecialchars($objective); ?></textarea>

        <?php if (isset($errorObjective)): ?>
        <span class="error"><?php echo $errorObjective; ?></span>
        <?php endif; ?>


        <h2>Skills</h2>

        <label for="skills">Technical Skills</label>

        <textarea
            name="skills"
            id="skills"
            rows="4"
            placeholder="Example: HTML, CSS, PHP, Java, SQL"
        ><?php echo htmlspecialchars($skills); ?></textarea>

        <?php if (isset($errorSkills)): ?>
        <span class="error"><?php echo $errorSkills; ?></span>
        <?php endif; ?>


        <label for="softskills">Soft Skills</label>

        <textarea
            name="softskills"
            id="softskills"
            rows="4"
            placeholder="Example: Communication, Teamwork, Problem Solving"
        ><?php echo htmlspecialchars($softskills); ?></textarea>

        <?php if (isset($errorSoftskills)): ?>
        <span class="error"><?php echo $errorSoftskills; ?></span>
        <?php endif; ?>


        <h2>Experience</h2>

        <label for="experiences">Work Experience</label>

        <textarea
            name="experiences"
            id="experiences"
            rows="5"
            placeholder="Enter your work experience"
        ><?php echo htmlspecialchars($experiences); ?></textarea>

        <?php if (isset($errorExperiences)): ?>
        <span class="error"><?php echo $errorExperiences; ?></span>
        <?php endif; ?>


        <h2>Certifications</h2>

        <label for="certifications">Certifications</label>

        <textarea
            name="certifications"
            id="certifications"
            rows="4"
            placeholder="Enter your certifications"
        ><?php echo htmlspecialchars($certifications); ?></textarea>

        <?php if (isset($errorCertifications)): ?>
        <span class="error"><?php echo $errorCertifications; ?></span>
        <?php endif; ?>


        <h2>Languages</h2>

        <label for="languages">Languages</label>

        <textarea
            name="languages"
            id="languages"
            rows="3"
            placeholder="Example: English, Filipino"
        ><?php echo htmlspecialchars($languages); ?></textarea>

       <?php if (isset($errorLanguages)): ?>
        <span class="error"><?php echo $errorLanguages; ?></span>
        <?php endif; ?>


        <h2>Projects / Internships</h2>

        <label for="projects">Projects or Internships</label>

        <textarea
            name="projects"
            id="projects"
            rows="5"
            placeholder="Enter your projects or internship experience"
        ><?php echo htmlspecialchars($projects); ?></textarea>

        <?php if (isset($errorProjects)): ?>
        <span class="error"><?php echo $errorProjects; ?></span>
        <?php endif; ?>

        <button type="submit">Create Resume</button>

    </form>

</div>

</body>
</html>