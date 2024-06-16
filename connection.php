<?php

$server="localhost";
$username="root";
$password="";
$dbname="hamba";

$con=mysqli_connect($server,$username,$password,$dbname);
if(!$con)
{
    echo"<h1>not connected</h1>";
}

?>