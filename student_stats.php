<?php

$average_q = $db->prepare('SELECT ROUND(AVG(grades.grade),1) AS average FROM students LEFT JOIN grades ON grades.student_id = students.id LEFT JOIN lessons ON grades.lessons_id = lessons.id WHERE students.username = :std_username');

$average_q->bindParam(':std_username', $student_username);
$average_q->execute();
$average = $average_q->fetch();
$average_q->closeCursor();

?>

<table>
    <tr>
        <th>Lesson</th>
        <th>Grade</th>
    </tr>
     <!-- Get an array from the DB query and cycle
      through each row of data -->
      <?php foreach($grades as $grade) : ?>
        <tr>
          <!-- Print out individual column data -->
          <td><?php echo $grade['subject']; ?></td>
          <td><?php echo $grade['grade']; ?></td>
        </tr>
      <!-- Mark the end of the foreach loop -->
      <?php endforeach; ?>
</table>

<div class="avg" style=" padding-top: 2rem;">
  <span style="font-weight: bold; ">Average Grade</span>: <?php echo $average['average']; ?> 
</div>