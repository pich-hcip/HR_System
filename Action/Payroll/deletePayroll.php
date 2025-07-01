<?php
session_start();
require_once '../../Config/connect.php';

// Check if PayId is provided
if (!isset($_GET['PayId'])) {
    $_SESSION['message'] = "No payroll ID provided";
    $_SESSION['message_type'] = "danger";
    header("Location: ../../view/Payroll/payroll.php");
    exit();
}

$payId = mysqli_real_escape_string($con, $_GET['PayId']);

// Delete the payroll record
$query = "DELETE FROM payroll WHERE PayId = '$payId'";
    
if (mysqli_query($con, $query)) {
    $_SESSION['message'] = "Payroll record deleted successfully";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Error deleting payroll: " . mysqli_error($con);
    $_SESSION['message_type'] = "danger";
}

mysqli_close($con);
header("Location: ../../view/Payroll/payroll.php");
exit();
?>