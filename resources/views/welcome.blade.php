<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Your Question</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM6g0g5z5e5e5e5e5e5e5e5e5e5e5e5e5e5e" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-image: url('images/questions.png');
            background-size: cover;
            background-position: center;
        }
        #card-container {
            width: 100%;
            max-width: 600px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(232, 223, 223, 0.1);
            background-color: #ffffff;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 10px;
        }
        textarea {
            width: 85%;
            height: 50px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
            resize: none;
            box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.4);
        }
        input[type="text"] {
            width: 85%;
            height: 40px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.4);
        }
        button {
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            background-color: #6F1FD8;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.4);
        }
        h2{
            margin-bottom: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .success-message {
            color: green;
            margin-top: 10px;
            display: none; /* Initially hidden */
        }
        footer {
            margin-top: 20px;
            padding: 10px;
            text-align: center;
            width: 100%;
        }
        .social-icons {
            display: flex;
            justify-content: center; /* Center the icons */
            margin-top: 10px;
        }
        .social-icons a {
            margin: 0 20px; /* Space between icons */
            color: #333; /* Icon color */
            font-size: 30px; /* Icon size */
            transition: transform 0.3s; /* Add transition for hover effect */
        }
        .social-icons a:hover {
            transform: scale(1.1); /* Scale up on hover */
        }
    </style>
</head>
<body>
    <div id="card-container">
        <h2 class="text-xl font-semibold">Submit Your Question</h2>
        <form id="question-form" action="/questions" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Your Name" required>
            <textarea id="question-input" name="question" placeholder="Type your question here..." required></textarea>
            <button type="submit">Submit</button>
        </form>
        <div id="success-message" class="success-message">Your question has been submitted successfully!</div>
    </div>

    <footer id="card-container">

        <p>come find us</p>
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank" class="fab fa-facebook-f"></a>
            <a href="https://twitter.com" target="_blank" class="fab fa-twitter"></a>
            <a href="https://instagram.com" target="_blank" class="fab fa-instagram"></a>
            <a href="https://linkedin.com" target="_blank" class="fab fa-linkedin-in"></a>
        </div>
        <div class="copyright">
            <p>&copy; 2024 Torc.dev All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.getElementById('question-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(this); // Create a FormData object from the form

            // Send the form data using Fetch API
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Indicate that this is an AJAX request
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json(); // Parse the JSON response
            })
            .then(data => {
                // Show the success message
                const successMessage = document.getElementById('success-message');
                successMessage.style.display = 'block'; // Show the message
                successMessage.innerText = data.message; // Set the message text
                document.getElementById('question-form').reset(); // Reset the form
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
                alert('There was an error submitting your question. Please try again.'); // Show an error message
            });
        });

        // Allow form submission on pressing Enter
        document.getElementById('question-input').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent the default action (new line in textarea)
                document.getElementById('question-form').dispatchEvent(new Event('submit')); // Trigger the submit event
            }
        });
    </script>
</body>
</html>
