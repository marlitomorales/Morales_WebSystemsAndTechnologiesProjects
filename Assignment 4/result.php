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
}

if ($contact == '') {
    $errorContact = "Contact Number is required.";
    $error = true;
}

if ($email == '') {
    $errorEmail = "Email is required.";
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