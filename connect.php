<?php

 require_once 'user.php';

 //create connection. First need to instantiate new mysqli class
 $conn =  new Mysqli(DB_SERVER, DB_USERNAME,DB_PASSWORD, DB_NAME);

 //check if connection is successful
 if ($conn->connect_error){
     die("Connection failed:". $conn->connect_error);
 }
 
?>