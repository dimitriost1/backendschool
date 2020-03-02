<?php 

session_start();
// print_r($_SESSION);
$username = $_SESSION['username'];
require('db_connect.php');

$query_student = 'SELECT first_name, last_name, username  FROM students';

$student_statement = $db->prepare($query_student);
$student_statement->execute();
$students = $student_statement->fetchAll();
$student_statement->closeCursor();


// print_r($student)

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>teacher main</title>
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
    <div class="welcome">
        Hello <?php echo $username; ?> !
    </div>
    <a href="login.php" class="logout">Logout</a>

    <div class="student_list">
        <p>Click to students username to add grade:</p>

        <table>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Username</th>
    </tr>
     <!-- Get an array from the DB query and cycle
      through each row of data -->
      <?php foreach($students as $student) : ?>
        <tr>
          <!-- Print out individual column data -->
          <td><?php echo $student['first_name']; ?></td>
          <td><?php echo $student['last_name']; ?></td>
          <?php  $std_username = $student['username']; ?>
          <td><?php echo '<a href="add_grade.php?std_username='.$std_username.'">'.$std_username.'</a>'; ?></td>
        </tr>
      <!-- Mark the end of the foreach loop -->
      <?php endforeach; ?>
</table>

    </div>
</body>
</html>