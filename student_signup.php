  <?php

  session_start();

  include('db_connect.php');

  if (isset($_POST['submit'])) {

    // echo "form submited" . "<br>";

    $errors = 0;
    $first_name = trim(htmlspecialchars($_POST["first_name"]));
    $last_name = trim(htmlspecialchars($_POST["last_name"]));
    $username = trim(htmlspecialchars($_POST["username"]));
    $password = trim(htmlspecialchars($_POST["password"]));
    $repassword = trim(htmlspecialchars($_POST["repassword"]));
    $_SESSION["first_name"] =  $first_name;
    $_SESSION["last_name"] =  $last_name;
    $_SESSION["username"] =  $username;
    $_SESSION["password"] =  $password;
  }
  ?>




  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/form.css" />
    <title>Login</title>
    <style>
      button {
        width: 10rem;
        height: 2rem;
        margin: 2rem;
        border-radius: 30px;
        font-weight: bold;
        color: aliceblue;
      }

      button:hover {
        color: #4a4ab4;
        background-color: aliceblue;
      }

      .btn {
        display: flex;
        justify-content: center;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <div class="form">
        <h2>Sign up!</h2>
        <form action="<?php echo  $_SERVER['PHP_SELF']; ?>" method="post">
          <input type="text" placeholder="First Name" name="first_name" value="<?php echo isset($first_name) ? $first_name : ''; ?>" />
          <?php if (isset($first_name) and (empty($first_name))) : ?>
            <div class="error">
              <?php echo "First Name is Empty";
              $errors  = 1;
              ?>
            </div>
          <?php endif; ?>

          <input type="text" placeholder="Last Name" name="last_name" value="<?php echo isset($last_name) ? $last_name : ''; ?>" />
          <?php if (isset($last_name) and (empty($last_name))) : ?>
            <div class="error">
              <?php echo "Last Name is Empty";
              $errors  = 1;
              ?>
            </div>
          <?php endif; ?>

          <input type="text" placeholder="Username" name="username" value="<?php echo isset($username) ? $username : ''; ?>" />
          <?php if (isset($username) and (empty($username))) : ?>
            <div class="error">
              <?php echo "Username is Empty";
              $errors  = 1;
              ?>
            </div>
          <?php endif; ?>
          <?php
          include('unique_username.php');
          ?>

          <input type="password" placeholder="Password" name="password" value="<?php echo isset($password) ? $password : ''; ?>" />
          <?php if (isset($_POST['submit']) and (empty($password))) : ?>
            <div class="error">
              <?php echo "Password is Empty";
              $errors  = 1;
              ?>
            </div>
          <?php endif; ?>

          <input type="password" name="repassword" placeholder="retype password" value="<?php echo isset($repassword) ? $repassword : ''; ?>" />
          <?php if (isset($password)  && ($password != $repassword)) : ?>
            <div class="error">
              <?php echo "passwords doesn't match";
              $errors  = 1;
              ?>
            </div>
          <?php endif; ?>



          <div class="btn">
            <button name="submit">Submit</button>
          </div>
        </form>
      </div>
    </div>

  </body>

  </html>

  <?php

  if (isset($_POST['submit'])) {
    if ($errors == 0) {
      $query = 'INSERT INTO students (first_name, last_name, username, password) VALUES (:first_name, :last_name, :username, :password )';
      # Create a PDOStatement object
      $stm = $db->prepare($query);
      # Bind values to parameters in the prepared statement
      $stm->bindValue(':first_name', $first_name);
      $stm->bindValue(':last_name', $last_name);
      $stm->bindValue(':username', $username);
      $stm->bindValue(':password', $password);

      # Execute the query and store true or false based on success
      $execute_success = $stm->execute();
      $stm->closeCursor();

      # If an error occurred print the error
      if (!$execute_success) {
        print_r($stm->errorInfo()[2]);
      }
      
      header('Location: student_suceess.php');
    }
  }

  ?>