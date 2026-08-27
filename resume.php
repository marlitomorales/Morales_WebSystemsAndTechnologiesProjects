<?php



$fullname = "Marlito T. Morales Jr.";
$email = "marlitotribianamoralesjr@gmail.com";
$address = "Umingan, Pangasinan";
$phoneNumber = "0967-077-2553";
$parentsName = "Marlito F. Morales Sr. and Lilybeth T. Morales";
$parentsContact = "0927-344-4111";
$program = "BS Information Technology";
$photo = "Profile.png";




if ($program == "BS Information Technology") {
    $careerTrack = "Systems Administrator";
} elseif ($program == "BS Computer Science") {
    $careerTrack = "Software Developer";
} else {
    $careerTrack = "IT Professional";
}




if ($careerTrack == "Systems Administrator") {
    $coreSkills = "Linux OS, Apache Server Configuration, Hardware Troubleshooting";
} elseif ($careerTrack == "Software Developer") {
    $coreSkills = "PHP, MySQL, Conditional Logic, Object-Oriented Programming";
} else {
    $coreSkills = "Basic Computer Troubleshooting, Microsoft Office, Basic Networking";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Resume</title>
</head>

<body>

    <h1><?php echo $fullname; ?></h1>

    <p>
        Email: <?php echo $email; ?><br>
        Address: <?php echo $address; ?><br>
        Phone Number: <?php echo $phoneNumber; ?>
    </p>

    <p>
        <img src="<?php echo $photo; ?>" alt="Profile Photo" width="150">
    </p>


    <h2>Personal Information</h2>

    <p>
        Full Name: <?php echo $fullname; ?><br>
        Program: <?php echo $program; ?><br>
        Parents Name: <?php echo $parentsName; ?><br>
        Parents Contact Number: <?php echo $parentsContact; ?>
    </p>


    <h2>Career Objective</h2>

    <p>
        To obtain a position as a
        <?php echo $careerTrack; ?>
        where I can apply my knowledge and skills,
        gain experience, and contribute to the organization.
    </p>


    <h2>Technical Skills</h2>

    <ul>
        <li><?php echo $coreSkills; ?></li>
    </ul>


    <h2>Education</h2>

    <p>
        <?php echo $program; ?>
    </p>

</body>

</html>