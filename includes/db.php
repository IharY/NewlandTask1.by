<?php
 $connection = mysqli_connect('127.0.0.1', 'root', 'root', 'newlandtask');
 if ($connection == false){
     echo 'no connection';
     echo mysqli_connect_error();
     exit();
 } 

 $result = mysqli_query($connection, "SELECT * FROM `articles_categories`")
?>