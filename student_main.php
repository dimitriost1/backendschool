<?php

session_start();
// print_r($_SESSION);
$username = $_SESSION['username'];
require('db_connect.php');

$query_student = 'SELECT first_name, last_name, username  FROM students WHERE username= :username';

$student_statement = $db->prepare($query_student);
$student_statement->bindParam(':username', $username);
$student_statement->execute();
$student = $student_statement->fetch();
$student_statement->closeCursor();

$student_username = $student['username'];
$student_fname = $student['first_name'];
$student_lname = $student['last_name'];
// print_r($student)

$grades_q = $db->prepare('SELECT lessons.subject, grades.grade, students.username FROM students LEFT JOIN grades ON grades.student_id = students.id LEFT JOIN lessons ON grades.lessons_id = lessons.id WHERE students.username = :std_username ');
$grades_q->bindParam(':std_username', $student_username);
$grades_q->execute();
$grades = $grades_q->fetchAll();
$grades_q->closeCursor();
// print_r($grades);
// echo '<br>'.gettype($grades[0]['subject']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>student main</title>
    <link rel="stylesheet" href="css/table.css">
    <style>
        .logout {
            position: fixed;
            right: 10px;
            top: 5px;
        }
    </style>
</head>

<body>
    <h1>Student Page</h1>
    <a href="login.php" class="logout">Logout</a>
    <div class="profile">
        <p>username: <?php echo $student_username; ?></p>
        <p>firtst name: <?php echo $student_fname; ?></p>
        <p>last name: <?php echo $student_lname; ?></p>
    </div>

    <div class="grades">
        <?php

        if (gettype($grades[0]['subject']) == gettype(NULL)) {
            echo "<h2>You have not any graded lesson</h2>";
        } else {
            include("student_stats.php");
        }

        ?>
    </div>
</body>

</html>