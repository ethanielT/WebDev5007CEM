document.addEventListener('DOMContentLoaded', () => {
    // Populate dropdowns with data from server
    function populateDropdown(url, selectElement, key1, key2) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                selectElement.innerHTML = ''; // Clear existing options
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item[key1];
                    option.textContent = item[key2]; // Adjust based on data
                    selectElement.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Populate users and quizzes dropdowns
    const userSelect = document.getElementById('userId');
    const quizSelect = document.getElementById('quizId');

    populateDropdown('api/get_users.php', userSelect, 'id', 'username');
    populateDropdown('api/get_quizzes.php', quizSelect, 'id', 'title');

    // Handle delete user
    const deleteUserButton = document.getElementById('deleteUserButton');
    deleteUserButton.addEventListener('click', () => {
        const userId = userSelect.value;
        if (!userId) {
            alert('Please select a user.');
            return;
        }

        if (confirm('Are you sure you want to delete this user?')) {
            fetch('api/delete_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('User deleted');
                    populateDropdown('api/get_users.php', userSelect, 'id', 'username');
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred');
            });
        }
    });

    // Handle delete quiz
    const deleteQuizButton = document.getElementById('deleteQuizButton');
    deleteQuizButton.addEventListener('click', () => {
        const quizId = quizSelect.value;
        if (!quizId) {
            alert('Please select a quiz.');
            return;
        }

        if (confirm('Are you sure you want to delete this quiz?')) {
            fetch('api/delete_quiz.php', {
                method: "POST",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ id: quizId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Quiz deleted');
                    populateDropdown('api/get_quizzes.php', quizSelect, 'id', 'title');
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred');
            });
        }
    });
});
