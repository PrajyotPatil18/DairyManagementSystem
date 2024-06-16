<?php

include("connection.php");

// Fetch the maximum ID value from the history table
$query_max_id = "SELECT MAX(id) as max_id FROM history";
$result_max_id = mysqli_query($con, $query_max_id);
$row_max_id = mysqli_fetch_assoc($result_max_id);
$max_id = $row_max_id['max_id'];

// Increment the maximum ID value to generate the next ID
$new_id = $max_id + 1;

$name = $_GET['t1'];
$line = $_GET['t2'];
$tomil = $_GET['t3'];
$rate = $_GET['t4'];
$toamo = $_GET['t5'];
$pro = $_GET['t6'];
$bala = $_GET['t7'];
$paid = $_GET['t8'];
$mob = $_GET['t9'];
$date = $_GET['t10'];
$month=$_GET['t11'];

// Insert the new record with the incremented ID
$sql = "INSERT INTO `history`(`id`, `name`, `line`, `total_milk`, `rate`, `total_amount`, `products`, `balance`, `paid`, `phone`, `date`,`month`) VALUES ('$new_id','$name','$line','$tomil','$rate','$toamo','$pro','$bala','$paid','$mob','$date','$month')";
$a = mysqli_query($con, $sql);

if ($a) {
    
   echo "<script> alert('Customer Added Successfully') ,window.location.href = 'adddetails.html' </script>";
} 

else {
    echo "<script> alert('Failed To Add Customer') window.location.href = 'adddetails.html' </script>";
}

?>
