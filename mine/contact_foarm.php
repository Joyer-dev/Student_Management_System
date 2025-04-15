<?php
// Include the PHP code for handling form submission, if needed
// Submit message functionality could also be placed here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        /* General Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc); /* Gradient Background */
            margin: 0;     
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Form Container Styling */
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        /* Header Styling */
        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Label Styling */
        label {
            font-size: 16px;
            margin-bottom: 8px;
            color: #444;
            text-align: left;
            display: block;
        }

        /* Input Field Styling */
        input[type="text"], 
        input[type="email"], 
        input[type="text"]:focus, 
        textarea {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            transition: border 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus, 
        input[type="email"]:focus,
        textarea:focus {
            border-color: #2575fc;
            outline: none;
        }

        /* Textarea Styling */
        textarea {
            height: 120px;
        }

        /* Submit Button Styling */
        button {
            width: 100%;
            padding: 14px;
            background-color: #2575fc;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #6a11cb;
        }

        /* Error Message Styling */
        .error {
            color: red;
            font-size: 12px;
            display: none;
            text-align: left;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        /* Text Link Styling */
        p {
            font-size: 14px;
            color: #444;
        }

        p a {
            text-decoration: none;
            color: #2575fc;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Contact Us</h1>
        <form action="submit_message.php" method="POST" id="contactForm" onsubmit="return validateForm()">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <div class="error" id="nameError">Please enter your name.</div>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <div class="error" id="emailError">Please enter a valid email address.</div>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>
            <div class="error" id="subjectError">Please enter a subject.</div>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
            <div class="error" id="messageError">Please enter a message.</div>

            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        // Form validation in JavaScript
        function validateForm() {
            let valid = true;

            // Clear all error messages
            document.querySelectorAll('.error').forEach(function(error) {
                error.style.display = 'none';
            });

            // Name validation
            let name = document.getElementById('name').value;
            if (name === "") {
                document.getElementById('nameError').style.display = 'block';
                valid = false;
            }

            // Email validation
            let email = document.getElementById('email').value;
            let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(email)) {
                document.getElementById('emailError').style.display = 'block';
                valid = false;
            }

            // Subject validation
            let subject = document.getElementById('subject').value;
            if (subject === "") {
                document.getElementById('subjectError').style.display = 'block';
                valid = false;
            }

            // Message validation
            let message = document.getElementById('message').value;
            if (message === "") {
                document.getElementById('messageError').style.display = 'block';
                valid = false;
            }

            return valid; // If form is not valid, it won't be submitted
        }
    </script>
</body>
</html>
