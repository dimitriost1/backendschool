<?php

session_start();
// print_r($_SESSION);

$first_name = $_SESSION["first_name"];
$last_name = $_SESSION["last_name"];
$username = $_SESSION["username"];
$password = $_SESSION["password"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher</title>
</head>

<body>
    <h1>Dear <?php echo $first_name.' ' .$last_name; ?>,  your registration is complete!</h1>
    <p>username: <?php echo $username; ?> </p>  
    <p>password: <?php echo $password; ?> </p>  
    <a href="login.php"><button>Sign in</button> </a>
</body>

</html>