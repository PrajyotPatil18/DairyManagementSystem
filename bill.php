<?php
include("connection.php");

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the updated data from the form
    $id = $_POST['id'];
    $name = $_POST['t1'];
    $line = $_POST['t2'];
    $totalmilk = $_POST['t3'];
    $rate = $_POST['t4'];
    $totalamount = $_POST['t5'];
    $products = $_POST['t6'];
    $balance = $_POST['t7'];
    $paid = $_POST['t8'];
    $phone = $_POST['t9'];
    $date = $_POST['t10'];
    $month=$_POST['t11'];    
    // Constructing the SQL query to update data
    $sql = "UPDATE `history` SET 
            `name`='$name',
            `line`='$line',
            `total_milk`='$totalmilk',
            `rate`='$rate',
            `total_amount`='$totalamount',
            `products`='$products',
            `balance`='$balance',
            `paid`='$paid',
            `phone`='$phone',
            `date`='$date' ,
            `month`='$month' 
            WHERE id='$id'";

    // Executing the SQL query
    if (mysqli_query($con, $sql)) {
        header('location: showhistory.php');
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}

// Function to fetch existing data from the database based on ID
function fetchData($con, $id) {
    $query = "SELECT * FROM history WHERE id='$id'";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Customer Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: calc(100% - 10px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            display: block;
            width: 150px;
            margin: 0 auto;
            padding: 20px;
            border: none;
            border-radius: 5px;
            background-color: #0dff21;
            color: rgb(255, 252, 252);
            cursor: pointer;
            font-weight: bolder;
        }
        input[type="reset"]{
            display: inline;
            width: 100px;
            margin: 0 auto;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #0770c5;
            color: white;
            cursor: pointer;
        }
    </style>
   
    <script>
        function calculateTotalAmount() {
            var totalMilk = parseFloat(document.getElementById('total_milk').value);
            var rate = parseFloat(document.getElementById('rate').value);
            var productPrice = parseFloat(document.getElementById('product_price').value) || 0;
            var totalAmount = totalMilk * rate + productPrice;
            document.getElementById('total_amount').value = totalAmount.toFixed(2);
        }
        function TotalAmount() {
            var totalamount= parseFloat(document.getElementById('total_amount').value);
            var balance = parseFloat(document.getElementById('balance').value);
            var paid = totalamount + balance;
            document.getElementById('paid').value = paid.toFixed(2);
        }

       /* function updateBalance() {
            var totalAmount = parseFloat(document.getElementById('total_amount').value);
            var paid = parseFloat(document.getElementById('paid').value) || 0;
            var balance = totalAmount - paid;
            document.getElementById('balance').value = balance.toFixed(2);
        }*/
    </script>
    
</head>
<body>
    
        <h2>Generate A Bill</h2><button class="red">
       
        <form action="bill1.php">
    <button type="submit" style="background-color: red; color: white; border: none; padding: 10px 20px; cursor: pointer;">Back</button>
</form>

        
        <form action="pdf.php" method="post">
        
            <?php
            // Fetch existing data based on id
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                $existingData = fetchData($con, $id);
            ?>
            <!-- Hidden field to hold the ID -->
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <!-- Rest of the form fields -->
           
        <table>
            <tr>
                <td><label for="name">Name:</label></td>
                <td><input type="text" id="name" name="t1"  value="<?php echo $existingData['name']; ?>"></td>
            </tr>
            <tr>
                <td><label for="name">Month:</label></td>
                <td><input type="month" id="month" name="t11" value="<?php echo $existingData['month']; ?>"></td>
            </tr>
            <tr>
                <td><label for="line">Line:</label></td>
                <td><input type="text" id="line" name="t2" value="<?php echo $existingData['line']; ?>"></td>
            </tr>
            <tr>
                <td><label for="phone">Phone:</label></td>
                <td><input type="text" id="phone" name="t9" value="<?php echo $existingData['phone']; ?>"></td>
            </tr>
            <tr>
                <td><label for="date">Date:</label></td>
                <td><input type="date" format="dd/mm/yyyy" id="date" name="t10" value="<?php echo $existingData['date']; ?>"></td>
            </tr>
        </table>

        <table>
            <tr>
                <td><label for="total_milk">Total Milk:</label></td>
                <td><input type="number" id="total_milk" name="t3" step="0.01" oninput="calculateTotalAmount()" value="<?php echo $existingData['total_milk']; ?>"></td>
            </tr>
            <tr>
                <td><label for="rate">Rate:</label></td>
                <td><input type="number" id="rate" name="t4" step="0.01" oninput="calculateTotalAmount()" value="<?php echo $existingData['rate']; ?>"></td>
            </tr>
          
            <tr>
                <td><label for="product_price">Price of Products(Ghee/butter/etc):</label></td>
                <td><input type="number" id="product_price" name="t6" step="0.01" oninput="calculateTotalAmount()" value="<?php echo $existingData['products']; ?>"></td>
            </tr>
            <tr>
                <td><label for="total_amount">Total Amount:</label></td>
                <td><input type="text" id="total_amount" name="t5" readonly value="<?php echo $existingData['total_amount']; ?>"></td>
            </tr>
            <tr>
                <td><label for="balance">Previous Month Balance Amount:</label></td>
                <td><input type="number" id="balance" name="t7" step="0.01" oninput="TotalAmount()" required></td>
            </tr>
            <tr>
                <td><label for="total paid">Total Including Balance:</label></td>
                <td><input type="text" id="paid" name="t8" readonly ></td>
            </tr>

           
            
        </table>
        <form action="pdf.php">
        <input type="submit" name="submit" value="print"></form>
        <?php
    }
    ?>
    </form>

    

</body>
</html>