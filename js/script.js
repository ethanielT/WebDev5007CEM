document.addEventListener('DOMContentLoaded', () => {
    // Fetch quizzes for the home page
    fetch('api/get_quizzes.php')
        .then(response => response.json())
        .then(data => {
            const quizzesDiv = document.getElementById('quizzes');
            if (quizzesDiv) {
                data.forEach(quiz => {
                    const quizElement = document.createElement('div');
                    quizElement.innerText = quiz.title;
                    quizzesDiv.appendChild(quizElement);
                });
            }
        });

    // Login form handling
    const loginForm = document.getElementById('loginForm');
    const loginError = document.getElementById('loginError');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(loginForm);
            fetch('api/login.php', {
                method: 'POST',
                body: JSON.stringify(Object.fromEntries(formData)),
                headers: { 'Content-Type': 'application/json' }
            }).then(response => response.json())
              .then(data => {
                  if (data.status === 'success') {
                      window.location.href = 'index.php';
                  } else {
                      loginError.textContent = data.message;
                  }
              });
        });
    }

    // Register form handling
    const registerForm = document.getElementById('registerForm');
    const registerError = document.getElementById('registerError');
    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                registerError.textContent = 'Passwords do not match';
                return;
            }

            const formData = new FormData(registerForm);
            fetch('api/register.php', {
                method: 'POST',
                body: JSON.stringify(Object.fromEntries(formData)),
                headers: { 'Content-Type': 'application/json' }
            }).then(response => response.json())
              .then(data => {
                  if (data.status === 'success') {
                      window.location.href = 'login.php';
                  } else {
                      registerError.textContent = data.message;
                  }
              });
        });
    }

    // Create quiz form handling
    const createQuizForm = document.getElementById('createQuizForm');
    if (createQuizForm) {
        createQuizForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const title = document.getElementById('quizTitle').value;
            const questions = [];
            document.querySelectorAll('.question').forEach(questionDiv => {
                const questionText = questionDiv.querySelector('.questionText').value;
                const options = [];
                questionDiv.querySelectorAll('.option').forEach(optionDiv => {
                    options.push({
                        option_text: optionDiv.querySelector('.optionText').value,
                        is_correct: optionDiv.querySelector('.isCorrect').checked
                    });
                });
                questions.push({ question: questionText, options });
            });

            const payload = { title, questions };
            console.log('Payload:', payload); // Debugging output to ensure data is collected correctly

            fetch('api/create_quiz.php', {
                method: 'POST',
                body: JSON.stringify(payload),
                headers: { 'Content-Type': 'application/json' }
            }).then(response => response.json())
              .then(data => {
                  if (data.status === 'success') {
                      window.location.href = 'index.php';
                  } else {
                      alert(data.message);
                  }
              }).catch(error => {
                  console.error('Error:', error);
                  alert('An unexpected error occurred');
              });
        });
    }

    // Take quiz form handling
    const takeQuizForm = document.getElementById('takeQuizForm');
    const mainContent = document.getElementById('mainContent');

    if (takeQuizForm) {
        takeQuizForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Prepare form data
            const formData = new FormData(takeQuizForm);
            const quiz_id = new URLSearchParams(window.location.search).get('id');
            formData.append('quiz_id', quiz_id);

            fetch('submit_quiz.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
              .then(result => {
                  // Clear existing content and display the result
                  mainContent.innerHTML = `<h2>Quiz Result</h2><p>${result}</p>`;
              }).catch(error => {
                  console.error('Error:', error);
                  alert('An unexpected error occurred');
              });
        });
    }
});
