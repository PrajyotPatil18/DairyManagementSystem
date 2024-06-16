<!DOCTYPE html>
<html>
<head>
    <title>Display Data</title>
    <link rel="stylesheet" href="showstyle.css">
    <link rel="stylesheet" href="house.css">
</head>
<body>
<header>

<nav>
        
        <ul>
            <li><a class="green" href="house.html"><b>🏠︎ Home</b></a></li>
            <li><a class="blue" href="adddetails.html"><b>➕ Add Customer</b></a></li>
            <li><a class="yellow" href="showhistory.php"><b>🛢️ Display Data</b></a></li>
            <li><a class="voilet" href="showhistory.html"><b>🔍 Search Customer</b></a></li>
            <li><a class="orange" href="billsearch.php"><b>💰 Billing</b></a></li>
        </ul>
        
    </nav>
    <div class="logout">
            <form action="login.html">
            <button type="submit" href="login.html" class="red">Logout</button></form>
        </div>
</header>
<table><center><h2>History of Customer</h2></center>
    <tr>
        <th>id</th>
        <th>Name</th>
        <th>Month</th>
        <th>Line</th>
        <th>Total milk</th>
        <th>Rate</th>
        <th>Total amount</th>
        <th>Products</th>
        <th>Balance amount</th>
        <th>paid</th>
        <th>phone</th>
        <th>Date</th>
        <th colspan="4" text-align="center">Operation</th>
    </tr>
<?php

include("connection.php");

$query = "SELECT * FROM history";
$data = mysqli_query($con, $query);
$total = mysqli_num_rows($data);
if ($total != 0) {
    $counter = 1;
    while ($result = mysqli_fetch_assoc($data)) {
        echo "
        <tr>
            <td>".$counter."</td>
            <td>".$result['name']."</td>
            <td>".$result['month']."</td>
            <td>".$result['line']."</td>
            <td>".$result['total_milk']."</td>
            <td>".$result['rate']."</td>
            <td>".$result['total_amount']."</td>
            <td>".$result['products']."</td>
            <td>".$result['balance']."</td>
            <td>".$result['paid']."</td>
            <td>".$result['phone']."</td>
            <td>".$result['date']."</td>
            
            <td><a href='updatehistory.php?id=".$result['id']."' class='update-btn'>Update</a></td>
            <td><a href='deletehistory.php?id=".$result['id']."' class='delete-btn'>Delete</a></td>
            <td><a href='add.php?id=".$result['id']."' class='add-btn'>Continue</a></td>
        </tr>
        ";
        $counter++;
    }
}
?>
</table>
</body>
</html>
