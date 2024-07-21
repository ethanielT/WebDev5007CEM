<!DOCTYPE html>
<html>
<head>
    <title>Create Quiz - Quiz Website</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Create Quiz</h1>
    <form id="createQuizForm">
        <label for="quizTitle">Quiz Title:</label>
        <input type="text" id="quizTitle" name="title" required>

        <div id="questions">
            <div class="question">
                <label>Question:</label>
                <input type="text" class="questionText" required>
                <div class="options">
                    <div class="option">
                        <label>Option:</label>
                        <input type="text" class="optionText" required>
                        <label>Correct?</label>
                        <input type="checkbox" class="isCorrect">
                    </div>
                </div>
                <button type="button" class="addOption">Add Option</button>
            </div>
        </div>
        <button type="button" id="addQuestion">Add Question</button>
        <button type="submit">Create Quiz</button>
    </form>
    <script src="js/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('addQuestion').addEventListener('click', () => {
                const questionTemplate = document.querySelector('.question').cloneNode(true);
                questionTemplate.querySelectorAll('input').forEach(input => input.value = '');
                document.getElementById('questions').appendChild(questionTemplate);
            });

            document.addEventListener('click', (e) => {
                if (e.target && e.target.className === 'addOption') {
                    const optionTemplate = e.target.previousElementSibling.querySelector('.option').cloneNode(true);
                    optionTemplate.querySelectorAll('input').forEach(input => input.value = '');
                    e.target.previousElementSibling.appendChild(optionTemplate);
                }
            });
        });
    </script>
</body>
</html>
