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
                placeholder="Enter your full name"
                required
            >

            <label for="age">Age</label>
            <input 
                type="number" 
                id="age"
                name="age" 
                placeholder="Enter your age"
                required
            >

            <label for="contact">Contact Number</label>
            <input 
                type="text" 
                id="contact"
                name="contact" 
                placeholder="Enter your contact number"
            >

            <label for="email">Email</label>
            <input 
                type="email" 
                id="email"
                name="email" 
                placeholder="Enter your email"
            >

            <label for="address">Address</label>
            <input 
                type="text" 
                id="address"
                name="address" 
                placeholder="Enter your address"
            >


            <h2>Career Information</h2>

            <label for="program">Education / Program</label>

            <select name="program" id="program" required>
                <option value="">Select your program</option>
                <option value="Bachelor of Science in Information Technology">
                    Bachelor of Science in Information Technology
                </option>

                <option value="Bachelor of Science in Computer Science">
                    Bachelor of Science in Computer Science
                </option>

                <option value="Bachelor of Science in Civil Engineering">
                    Bachelor of Science in Civil Engineering
                </option>
            </select>


            <label for="objective">Career Objective</label>

            <textarea
                name="objective"
                id="objective"
                rows="4"
                placeholder="Enter your career objective"
            ></textarea>


            <h2>Skills</h2>

            <label for="skills">Technical Skills</label>

            <textarea
                name="skills"
                id="skills"
                rows="4"
                placeholder="Example: HTML, CSS, PHP, Java, SQL"
            ></textarea>


            <label for="softskills">Soft Skills</label>

            <textarea
                name="softskills"
                id="softskills"
                rows="4"
                placeholder="Example: Communication, Teamwork, Problem Solving"
            ></textarea>


            <h2>Experience</h2>

            <label for="experiences">Work Experience</label>

            <textarea
                name="experiences"
                id="experiences"
                rows="5"
                placeholder="Enter your work experience"
            ></textarea>


            <h2>Certifications</h2>

            <label for="certifications">Certifications</label>

            <textarea
                name="certifications"
                id="certifications"
                rows="4"
                placeholder="Enter your certifications"
            ></textarea>


            <h2>Languages</h2>

            <label for="languages">Languages</label>

            <textarea
                name="languages"
                id="languages"
                rows="3"
                placeholder="Example: English, Filipino"
            ></textarea>


            <h2>Projects / Internships</h2>

            <label for="projects">Projects or Internships</label>

            <textarea
                name="projects"
                id="projects"
                rows="5"
                placeholder="Enter your projects or internship experience"
            ></textarea>


            <button type="submit">Create Resume</button>

        </form>

    </div>

</body>
</html>