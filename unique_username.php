<?php 

$chk_std = $db->prepare("SELECT username FROM students WHERE username =  :std_name");
$chk_std->bindParam(':std_name', $username);
$chk_std->execute();


if ($chk_std->rowCount() > 0) {

  echo ' <div class="error">User already exists!</div>';
  $errors = 1;
}
$chk_std->closeCursor();



$chk = $db->prepare("SELECT username FROM teachers WHERE username =  :name");
$chk->bindParam(':name', $username);
$chk->execute();


if ($chk->rowCount() > 0) {

  echo ' <div class="error">User already exists!</div>';
  $errors = 1;
}
$chk->closeCursor();
