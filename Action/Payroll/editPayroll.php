<?php
session_start();
require_once '../../Config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payId = mysqli_real_escape_string($con, $_POST['PayId']);
    $empId = mysqli_real_escape_string($con, $_POST['EmpId']);
    $basicSalary = mysqli_real_escape_string($con, $_POST['BasicSalary']);
    $bonus = mysqli_real_escape_string($con, $_POST['Bonus']);

    $query = "UPDATE payroll SET 
              EmpId = '$empId',
              BasicSalary = '$basicSalary',
              Bonus = '$bonus'
              WHERE PayId = '$payId'";
    
    if (mysqli_query($con, $query)) {
        $_SESSION['message'] = "Payroll updated successfully";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error updating payroll: " . mysqli_error($con);
        $_SESSION['message_type'] = "danger";
    }
    
    mysqli_close($con);
    header("Location: ../view/Payroll/payroll.php");
    exit();
}
?>