document.getElementById('assessmentForm').addEventListener('submit', function (event) {
    event.preventDefault();

    // Get the answers from the input fields
    const answers = {
        q1: document.getElementById('q1').value,
        q2: document.getElementById('q2').value,
        q3: document.getElementById('q3').value,
        q4: document.getElementById('q4').value,
        q5: document.getElementById('q5').value,
    };

    // Calculate the score based on answers (for simplicity, assume 1 point for each correct answer)
    let score = 0;

    // Check answers
    if (answers.q1 === "32") score++; // Expected answer for question 1
    if (answers.q2.toLowerCase() === "yes") score++; // Expected answer for question 2
    if (answers.q3.toLowerCase() === "decrease") score++; // Expected answer for question 3
    if (answers.q4 === "3") score++; // Expected answer for question 4
    if (answers.q5.toLowerCase() === "dog") score++; // Expected answer for question 5

    // Redirect based on score (just a simple condition for demo)
    let depressionAnxietyLevel = 'Normal';
    if (score < 3) {
        depressionAnxietyLevel = 'High Anxiety/Depression';
    } else if (score < 5) {
        depressionAnxietyLevel = 'Moderate Anxiety/Depression';
    }

    // Store the result in localStorage or pass it to the next page
    localStorage.setItem('depressionAnxietyLevel', depressionAnxietyLevel);

    // Redirect to the next page where the results will be shown
    window.location.href = "results.html";
});
