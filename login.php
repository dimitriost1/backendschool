<?php

session_start();

include('db_connect.php');

if (isset($_POST['submit'])) {
    // echo "form submited!" . "<br>";

    $errors = 0;
    $username = trim(htmlspecialchars($_POST["username"]));
    $password = trim(htmlspecialchars($_POST["password"]));
    $_SESSION["username"] =  $username;
    $_SESSION["password"] =  $password;
    require('login_check.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/form.css">
    <title>Login</title>
    <style>
        .signup {
            margin: 2rem;
        }

        .signup span a {
            color: white;
            font-weight: bold;
            margin: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="form">
            <h2>Log In!</h2>
            <form action="<?php echo  $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="text" name="username" placeholder="username" value="<?php echo isset($username) ? $username : ''; ?>">
                <?php if (isset($username) and (empty($username))) : ?>
                    <div class="error">
                        <?php echo "Username is Empty";
                        $errors  = 1;
                        ?>
                    </div>
                <?php endif; ?>

                <input type="password" name="password" placeholder="password" value="<?php echo isset($password) ? $password : ''; ?>">
                <?php if (isset($password) and (empty($password))) : ?>
                    <div class="error">
                        <?php echo "Password is Empty";
                        $errors  = 1;
                        ?>
                    </div>
                <?php endif; ?>
                <?php if ( isset($_POST['submit']) and ($errors == 2)) : ?>
                    <?php echo "Wrong username or password!"; ?>
                <?php endif; ?>

                <input type="submit" name="submit" value="Sign In">
            </form>
            <div class="signup">
                Don't have an account? <span><a href="signup.html">Sign Up</a></span>
            </div>
        </div>

    </div>
</body>

</html>

<?php
if (isset($_POST['submit']) and $errors == 0) {
    header('Location: test.php');
    if ($occupation == "students") {
        header('Location: student_main.php');
    }elseif ($occupation =="teachers") {
        header('Location: teacher_main.php');
    }
}


?>