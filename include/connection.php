<?php
$connection= mysqli_connect('localhost','root','','asms');

//checking the connection
if(mysqli_connect_errno()) {
    die('Database connection failed.'.mysqli_connect_error());
}
else {
   // echo "Connection Successful.";
}


?>