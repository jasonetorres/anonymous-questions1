<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>questions</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
            max-width: 400px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(232, 223, 223, 0.1);
            background-color: #ffffff;
            border-radius: 10px;
            text-align: center;
        }
        .question-card {
            padding: 10px;
            margin: 10px 0;
            box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.4);
            border-radius: 10px;
        }
        button {
            margin: 5px;
            padding: 10px 20px;
            border: none;
            background-color: #6F1FD8;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.4);
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="card-container">
        <h2 class="text-xl font-semibold">Submitted Questions</h2>
        <div id="questions-container">
            <!-- Questions will be dynamically inserted here -->
            @foreach($questions as $index => $question)
                <div class="question-card" id="question-{{ $question->id }}">
                    <p><strong>Question:</strong> {{ $question->question }}</p>
                    <p><strong>Submitted by:</strong> {{ $question->name }}</p>
                </div>
            @endforeach
        </div>
        <div>
            <button id="prev-button" onclick="showPrevious()">Previous</button>
            <button id="next-button" onclick="showNext()">Next</button>
            <button id="delete-button" onclick="deleteQuestion()">Delete</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentQuestionIndex = 0;
            const questions = @json($questions); // Pass questions to JavaScript
            const questionCards = document.querySelectorAll('.question-card');

            // Function to display the current question
            function displayQuestion(index) {
                questionCards.forEach((question, i) => {
                    question.style.display = (i === index) ? 'block' : 'none'; // Show only the current question
                });
            }

            // Function to show the next question
            window.showNext = function() {
                if (currentQuestionIndex < questionCards.length - 1) {
                    currentQuestionIndex++;
                    displayQuestion(currentQuestionIndex);
                }
            };

            // Function to show the previous question
            window.showPrevious = function() {
                if (currentQuestionIndex > 0) {
                    currentQuestionIndex--;
                    displayQuestion(currentQuestionIndex);
                }
            };

            // Function to delete the current question
            window.deleteQuestion = function() {
                const questionId = questions[currentQuestionIndex].id; // Get the ID of the current question

                if (confirm('Are you sure you want to delete this question?')) {
                    fetch(`/questions/${questionId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token for security
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            // Remove the question card from the DOM
                            document.getElementById(`question-${questionId}`).remove();
                            // Update the current question index
                            if (currentQuestionIndex >= questionCards.length - 1) {
                                currentQuestionIndex--; // Move to the previous question if at the end
                            }
                            // Display the next question or the previous one
                            displayQuestion(currentQuestionIndex);
                        } else {
                            alert('Failed to delete the question. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                        alert('There was an error deleting the question. Please try again.');
                    });
                }
            };

            // Initial display
            displayQuestion(currentQuestionIndex);
        });
    </script>
</body>
</html>
