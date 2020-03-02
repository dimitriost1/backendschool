<?php

require('db_connect.php');
session_start();

if (!isset($_GET['submit'])) {
    $_SESSION['std_username'] = $_GET['std_username'];
}

$student_username = $_SESSION['std_username'];

if (isset($_GET['submit'])) {
    // print_r($_GET);
    // echo "<br>";
$lesson = $_GET['selected_lesson'];
$grades_q = $db->prepare('SELECT lessons.subject, grades.grade, students.username FROM students LEFT JOIN grades ON grades.student_id = students.id LEFT JOIN lessons ON grades.lessons_id = lessons.id WHERE students.username = :std_username AND lessons.subject = :lesson');
$grades_q->bindParam(':std_username', $student_username);
$grades_q->bindParam(':lesson', $lesson);
$grades_q->execute();

$exist_grade = $grades_q->rowCount();
$grades_q->closeCursor();

if ($exist_grade > 0) {
    $msg = "Grade in this subject already exists!";
}
elseif ($_GET['grade'] <0 or $_GET['grade'] >20) {
    $msg = "Please give a grade between 0 and 20.";
}

else {
    $msg = "Grade added succesfully!";

    $student_id_q = $db->prepare('SELECT id FROM students WHERE username  = :std_username');
    $student_id_q->bindParam(':std_username', $student_username);
    $student_id_q->execute();
    $student_id = $student_id_q->fetch()['id'];

    $lessons_id_q = $db->prepare('SELECT id FROM lessons WHERE subject  = :subject');
    $lessons_id_q->bindParam(':subject', $lesson);
    $lessons_id_q->execute();
    $lessons_id = $lessons_id_q->fetch()['id'];

    // echo '<br>'.'msg = '.$msg;
    // echo '<br>'.'student_id = '.$student_id;
    // echo '<br>'.'lessons_id = '.$lessons_id;

    $query = 'INSERT INTO grades (grade, lessons_id, student_id) VALUES (:grade, :lessons_id, :student_id)';
      # Create a PDOStatement object
      $stm = $db->prepare($query);
      # Bind values to parameters in the prepared statement
      $stm->bindValue(':grade', $_GET['grade']);
      $stm->bindValue(':lessons_id', $lessons_id);
      $stm->bindValue(':student_id', $student_id);

      # Execute the query and store true or false based on success
      $execute_success = $stm->execute();
      $stm->closeCursor();

      # If an error occurred print the error
      if (!$execute_success) {
        print_r($stm->errorInfo()[2]);
      }

      unset($_GET);
}
  
}

// echo "<br>" . $student_username;
// echo "<br>";
// print_r($_SESSION);
// echo "<br>";


$grades_q = $db->prepare('SELECT lessons.subject, grades.grade, students.username FROM students LEFT JOIN grades ON grades.student_id = students.id LEFT JOIN lessons ON grades.lessons_id = lessons.id WHERE students.username = :std_username');
$grades_q->bindParam(':std_username', $student_username);
$grades_q->execute();
$grades = $grades_q->fetchAll();
// print_r($grades);
$grades_q->closeCursor();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grading</title>
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
    <div class="logout">
        <a href="login.php">Logout</a> |
        <a href="teacher_main.php">Back to students list</a>
    </div>

    <h4>Current grades of <?php echo $student_username; ?>:</h4>
    <div class="grades">
        <?php
        if (gettype($grades[0]['subject']) == gettype(NULL)) {
            echo "<h2>The student has not any graded lesson</h2>";
        } else {
            include("student_stats.php");
        }

        ?>
    </div>

    <div class="add_grade" style="margin-top: 2rem;">
        <form action="add_grade.php" method="get">

            <select id="lessons" name="selected_lesson">
                <option disabled selected value> -- select lesson -- </option>
                <option value="math">math</option>
                <option value="history">history</option>
                <option value="computer science">computer science</option>
                <option value="physics">physics</option>
            </select>
            <div class="grade">

                <input type="number" name="grade" placeholder="enter the grade" required>
            </div>
            <button name="submit">Submit</button>
        </form>

        <?php
         if (isset($_GET['submit'])) {
             echo $msg;
         }
        ?>
    </div>
</body>

</html>