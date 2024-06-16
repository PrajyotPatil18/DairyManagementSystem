<?php
include("connection.php");

$id = $_GET['id'];

// Check if the user has confirmed the deletion
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    $query = "DELETE FROM `history` WHERE id='$id'";
    $data = mysqli_query($con, $query);
    
    if ($data) {
        header('location: showhistory.php');
    } else {
        echo "Error: Record not deleted";
    }
} else {
    // Display the confirmation window
    echo "
    <script>
    if(confirm('Are you sure you want to delete this record?')) {
        window.location.href = 'deletehistory.php?id=$id&confirm=yes';
    } else {
        window.location.href = 'showhistory.html';
    }
    </script>";
}
?>
