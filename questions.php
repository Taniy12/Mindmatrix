<?php
session_start();
include('db.php'); // Include database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $answers = [];
    
    // Loop through each question and capture the selected answers
    foreach ($_POST as $question_id => $answer) {
        if (is_numeric($question_id)) {
            $answers[$question_id] = $answer;
        }
    }

    // Now you can process the answers, e.g., save them to the database or go to the next page
    // For example, store the answers in the session
    $_SESSION['answers'] = $answers;

    // Redirect to the next page (e.g., result page)
    header('Location: result.php');
    exit;
}

// Fetch questions from the database
$questions_query = "SELECT * FROM questions";
$questions_result = mysqli_query($conn, $questions_query);

// Check if the query was successful
if (!$questions_result) {
    die("Error fetching questions: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mental Health Assessment - MindMatrix</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url(https://m.media-amazon.com/images/I/712-pW8y7gL._AC_UF894,1000_QL80_.jpg);
            min-height: 100vh;
            padding-top: 50px;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            background-color:rgb(231, 120, 120);  /* Lighter background color for the container */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            max-width: 700px;  /* Make container smaller */
            margin: 0 auto;
        }
        .question-container {
            margin-bottom: 25px;
        }
        .question-container p {
            font-weight: bold;
        }
        .form-check {
            display: inline-block;
            margin-right: 15px;
        }
        .btn-primary {
            width: 100%;
            font-size: 18px;
            padding: 12px;
            background-color:rgb(37, 238, 63);
            border: none;
        }
        .btn-primary:hover {
            background-color:rgb(61, 231, 69);
        }
    </style>
</head>
<body>

<div class="container col-md-8 mx-auto">
    <h2 class="text-center mb-4">Mental Health Assessment</h2>
    <p class="text-center text-muted">Please answer the following questions honestly.</p>

    <form method="POST">
        <?php while ($row = mysqli_fetch_assoc($questions_result)) { ?>
            <div class="question-container">
                <p><?php echo $row['question']; ?></p>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="<?php echo $row['id']; ?>" value="1" required>
                    <label class="form-check-label"><?php echo htmlspecialchars($row['option1']); ?></label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="<?php echo $row['id']; ?>" value="2" required>
                    <label class="form-check-label"><?php echo htmlspecialchars($row['option2']); ?></label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="<?php echo $row['id']; ?>" value="3" required>
                    <label class="form-check-label"><?php echo htmlspecialchars($row['option3']); ?></label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="<?php echo $row['id']; ?>" value="4" required>
                    <label class="form-check-label"><?php echo htmlspecialchars($row['option4']); ?></label>
                </div>
            </div>
        <?php } ?>

        <button type="submit" class="btn btn-primary">Submit Answers</button>
    </form>
</div>

</body>
</html>
