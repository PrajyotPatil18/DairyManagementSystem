<?php
include("connection.php");

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Fetch the maximum ID value from the history table
$query_max_id = "SELECT MAX(id) as max_id FROM history";
$result_max_id = mysqli_query($con, $query_max_id);
$row_max_id = mysqli_fetch_assoc($result_max_id);
$max_id = $row_max_id['max_id'];

// Increment the maximum ID value to generate the next ID
    $new_id = $max_id + 1;
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
    $sql = "INSERT INTO `history`(`id`, `name`, `line`, `total_milk`, `rate`, `total_amount`, `products`, `balance`, `paid`, `phone`, `date`, `month`)
         VALUES ('$new_id','$name','$line','$totalmilk','$rate','$totalamount','$products','$balance','$paid','$phone','$date','$month')";

    // Executing the SQL query
    if (mysqli_query($con, $sql)) {
        header('location: showhistory.php');
        exit;
    } else {
        echo "Error continuing Customer: " . mysqli_error($con);
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
        }

        h2 {
            text-align: center;
        }

        form {
            margin: 0 auto;
            max-width: 600px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        function updateBalance() {
            var totalAmount = parseFloat(document.getElementById('total_amount').value);
            var paid = parseFloat(document.getElementById('paid').value) || 0;
            var balance = totalAmount - paid;
            document.getElementById('balance').value = balance.toFixed(2);
        }
    </script>
    
</head>
<body>
    
        <h2>To continue customer change month</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                <td><label for="total_amount">Total Amount:</label></td>
                <td><input type="text" id="total_amount" name="t5" readonly value="<?php echo $existingData['total_amount']; ?>"></td>
            </tr>
            <tr>
                <td><label for="product_price">Price of Products:</label></td>
                <td><input type="number" id="product_price" name="t6" step="0.01" oninput="calculateTotalAmount()" value="<?php echo $existingData['products']; ?>"></td>
            </tr>

            <tr>
                <td><label for="paid">Paid:</label></td>
                <td><input type="number" id="paid" name="t8" step="0.01" oninput="updateBalance()" value="<?php echo $existingData['paid']; ?>"></td>
            </tr>

            <tr>
                <td><label for="balance">Balance Amount:</label></td>
                <td><input type="text" id="balance" name="t7" readonly  value="<?php echo $existingData['balance']; ?>"></td>
            </tr>
            
        </table>
        <input type="submit" name="submit" value="Continue customer"><input type="reset" name="reset" value="reset">
        <?php
    }
    ?>
    </form>

    

</body>
</html>