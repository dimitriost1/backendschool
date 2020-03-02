<?php

$chk_std = $db->prepare("SELECT username FROM students WHERE username =  :std_username AND password= :std_password");
$chk_std->bindParam(':std_username', $username);
$chk_std->bindParam(':std_password', $password);
$chk_std->execute();

// $all_students = $chk_std->fetchAll();

// print_r($all_students);


if ($chk_std->rowCount() > 0) {

    $occupation = "students";
    $_SESSION['occupation'] = $occupation;
    $chk_std->closeCursor();
} else {
    $chk_std->closeCursor();

    $chk = $db->prepare("SELECT username FROM teachers WHERE username =  :username AND password= :password");
    $chk->bindParam(':username', $username);
    $chk->bindParam(':password', $password);
    $chk->execute();


    if ($chk->rowCount() > 0) {

        $occupation = "teachers";
        $_SESSION['occupation'] = $occupation;
        $chk->closeCursor();
    }else {
        $errors = 2;
        $chk->closeCursor();
    }
    
}
