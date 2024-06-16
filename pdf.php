<?php
require('fpdf/fpdf.php');

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
    $month = $_POST['t11'];    
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
        // Generate PDF invoice
        generatePDFInvoice($con, $id);
       // header('location: showhistory.php');
        exit;
    } else {
        echo "error in generating pdf: " . mysqli_error($con);
    }
}

// Function to fetch existing data from the database based on ID
function fetchData($con, $id) {
    $query = "SELECT * FROM history WHERE id='$id'";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_assoc($result);
}

// Function to generate PDF invoice
function generatePDFInvoice($con, $id) {
    // Fetch existing data based on id
    $existingData = fetchData($con, $id);
    
    // Create new PDF instance
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('Arial', 'B', 12);

    // Write content
    $pdf->Image('dairy.jpg', 8, 8, 25);
    $pdf->Cell(0, 10, 'SIDDHIVINAYAK DUGDHALAYA', 0, 1, 'C');
    $pdf->Cell(0, 10, 'MOB. 9765875721/8275200315', 0, 1, 'C');
    $pdf->Ln();
    

    $pdf->Cell(60, 10, 'Line:', 1, 0);
    $pdf->Cell(130, 10, $existingData['line'], 1, 1);

    $pdf->Cell(30, 10, 'Date:', 1, 0);
    $pdf->Cell(50, 10, $existingData['date'], 1, 0);

    $pdf->Cell(30, 10, 'Month:', 1, 0);
    $pdf->Cell(0, 10, $existingData['month'], 1, 1);
    
    $pdf->Cell(60, 10, 'Name:', 1, 0);
    $pdf->Cell(130, 10, $existingData['name'], 1, 1);

    $pdf->Cell(80, 10, 'Total Milk:', 1, 0);
    $pdf->Cell(0, 10, $existingData['total_milk'], 1, 1);

    $pdf->Cell(80, 10, 'Rate:', 1, 0);
    $pdf->Cell(0, 10, $existingData['rate'], 1, 1);

    $pdf->Cell(80, 10, 'Price of Products:', 1, 0);
    $pdf->Cell(0, 10, $existingData['products'], 1, 1);

    $pdf->Cell(80, 10, 'Total Amount:', 1, 0);
    $pdf->Cell(0, 10, $existingData['total_amount'], 1, 1);
    $pdf->Cell(0, 5, 'please check the bill', 0, 1, 'C');

    $pdf->Cell(90, 10, 'previous month Balance Amount(if any):', 1, 0);
    $pdf->Cell(0, 10, $existingData['balance'], 1, 1);
    $pdf->Cell(80, 10, 'Total Amount(including balance):', 1, 0);
    $pdf->Cell(0, 10, $existingData['paid'], 1, 1);

    
    $pdf->Cell(0, 5, 'SIDDHIVINAYAK DUGDHALAY, JANTA SAHAKARI BANK,', 0, 1, 'C');
    $pdf->Cell(0, 5, ' SHANIWAR-NARAYAN PETH BRANCH,A/C NO.015-2301-0000-2737,', 0, 1, 'C');
    $pdf->Cell(0, 5, 'IFSC CODE:JSBP0000015', 0, 1, 'C');
    


    $pdf->Ln();
$pdf->Cell(0, 10, '', 0, 1); // Insert empty cell to create space
    
// Adjust position for images
$startX = 10; // Set X position for ajinkya.jpeg (bottom left corner)
$startY = $pdf->GetY(); // Get current Y position

// Display ajinkya.jpeg
$pdf->Image('ajinkya.jpeg', $startX, $startY, 50); // Adjust width to your preference

// Adjust position for prajyot.jpeg (bottom right corner)
$prajyotX = $pdf->GetPageWidth() - 60; // Set X position for prajyot.jpeg (60 is image width plus margin)
$prajyotY = $pdf->GetY(); // Get current Y position

// Display prajyot.jpeg
$pdf->Image('prajyot.jpeg', $prajyotX, $prajyotY, 50); // Adjust width to your preference

// Output PDF
$pdf->Output('invoice.pdf', 'I');

}
?>
