<?php 

define('DB_USER', 'root');
define('DB_PASSWORD','');

$dsn = 'mysql:host=localhost;dbname=school';

try{
    $db = new PDO($dsn, DB_USER, DB_PASSWORD);
    // include('debug.php');

}catch(PDOException $e){
    $err_msg = $e->getMessage();
    include('db_error.php');
    exit();
}
?>