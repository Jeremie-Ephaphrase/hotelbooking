<?php

require_once "user.php";
//create a connetion
$conn = new Mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
if($conn->connect_error){
    die("connection failed:".$conn->connection_error);
}
else{
    echo "connect";
}
 

?>