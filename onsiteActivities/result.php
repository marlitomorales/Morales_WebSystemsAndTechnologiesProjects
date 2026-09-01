<?php

$names = $_GET['FullName'] ?? '';
$ages = $_GET['age'] ?? '';
$courses = $_GET['program'] ?? '';

$contact = $_GET['contact'] ?? '';
$email = $_GET['email'] ?? '';
$address = $_GET['address'] ?? '';

$objective = $_GET['objective'] ?? '';

$skills = $_GET['skills'] ?? '';
$softskills = $_GET['softskills'] ?? '';

$experiences = $_GET['experiences'] ?? '';

$certifications = $_GET['certifications'] ?? '';

$languages = $_GET['languages'] ?? '';

$projects = $_GET['projects'] ?? '';


$names = htmlspecialchars($names);
$ages = htmlspecialchars($ages);
$courses = htmlspecialchars($courses);

$contact = htmlspecialchars($contact);
$email = htmlspecialchars($email);
$address = htmlspecialchars($address);

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

    <title><?php echo $names; ?> - Resume</title>

    <link rel="stylesheet" href="style.css">

</head>

<body class="resume-page">

    <div class="resume">

        <header class="resume-header">

            <h1>
                <?php echo $names; ?>
            </h1>

        </header>


        <div class="resume-content">

            <aside class="sidebar">

                <section>

                    <h2>CONTACT</h2>

                    <?php if ($contact != ''): ?>
                        <p><?php echo $contact; ?></p>
                    <?php endif; ?>

                    <?php if ($email != ''): ?>
                        <p><?php echo $email; ?></p>
                    <?php endif; ?>

                    <?php if ($address != ''): ?>
                        <p><?php echo $address; ?></p>
                    <?php endif; ?>

                    <?php if ($ages != ''): ?>
                        <p>Age: <?php echo $ages; ?></p>
                    <?php endif; ?>

                </section>


                <section>

                    <h2>CERTIFICATIONS</h2>

                    <?php if ($certifications != ''): ?>

                        <?php
                        $certList = preg_split(
                            '/\r\n|\r|\n/',
                            $certifications
                        );
                        ?>

                        <?php foreach ($certList as $cert): ?>

                            <?php if (trim($cert) != ''): ?>

                                <p>
                                    <?php echo trim($cert); ?>
                                </p>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </section>


                <section>

                    <h2>LANGUAGES</h2>

                    <?php if ($languages != ''): ?>

                        <?php
                        $languageList = preg_split(
                            '/\r\n|\r|\n/',
                            $languages
                        );
                        ?>

                        <?php foreach ($languageList as $language): ?>

                            <?php if (trim($language) != ''): ?>

                                <p>
                                    <?php echo trim($language); ?>
                                </p>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </section>

            </aside>

            <main class="main-content">

                <section class="resume-section">

                    <div class="section-title">

                        <span class="timeline-circle"></span>

                        <h2>CAREER OBJECTIVE</h2>

                    </div>

                    <p>
                        <?php echo nl2br($objective); ?>
                    </p>

                </section>

                <section class="resume-section">

                    <div class="section-title">

                        <span class="timeline-circle"></span>

                        <h2>KEY SKILLS</h2>

                    </div>


                    <?php if ($skills != ''): ?>

                        <p>
                            <strong>Technical Skills</strong>
                        </p>

                        <?php
                        $skillList = preg_split(
                            '/\r\n|\r|\n/',
                            $skills
                        );
                        ?>

                        <?php foreach ($skillList as $skill): ?>

                            <?php if (trim($skill) != ''): ?>

                                <p class="bullet-text">
                                    <?php echo trim($skill); ?>
                                </p>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endif; ?>


                    <?php if ($softskills != ''): ?>

                        <p>
                            <strong>Soft Skills</strong>
                        </p>

                        <?php
                        $softList = preg_split(
                            '/\r\n|\r|\n/',
                            $softskills
                        );
                        ?>

                        <?php foreach ($softList as $skill): ?>

                            <?php if (trim($skill) != ''): ?>

                                <p class="bullet-text">
                                    <?php echo trim($skill); ?>
                                </p>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </section>

                <section class="resume-section">

                    <div class="section-title">

                        <span class="timeline-circle"></span>

                        <h2>EXPERIENCE</h2>

                    </div>

                    <p>
                        <?php echo nl2br($experiences); ?>
                    </p>

                </section>

                <section class="resume-section">

                    <div class="section-title">

                        <span class="timeline-circle"></span>

                        <h2>EDUCATION</h2>

                    </div>

                    <p>
                        <?php echo $courses; ?>
                    </p>

                </section>

                <section class="resume-section">

                    <div class="section-title">

                        <span class="timeline-circle"></span>

                        <h2>PROJECTS / INTERNSHIPS</h2>

                    </div>

                    <p>
                        <?php echo nl2br($projects); ?>
                    </p>

                </section>


            </main>

        </div>
         <?php if ($email != ''): ?>

    <p class="resume-footer">
        <?php echo $email; ?>. All rights reserved
    </p>

    <?php endif; ?>

    </div>
        
  

</body>

</html>