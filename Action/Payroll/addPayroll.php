<?php
session_start();
require_once '../../Config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empId = mysqli_real_escape_string($con, $_POST['EmpId']);
    $basicSalary = mysqli_real_escape_string($con, $_POST['BasicSalary']);
    $bonus = mysqli_real_escape_string($con, $_POST['Bonus']);

    $query = "INSERT INTO payroll (EmpId, BasicSalary, Bonus) VALUES ('$empId', '$basicSalary', '$bonus')";
    
    if (mysqli_query($con, $query)) {
        $_SESSION['message'] = "Payroll added successfully";
        header("Location: /HR_SYSTEM/view/Payroll/payroll.ph");
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error adding payroll: " . mysqli_error($con);
        $_SESSION['message_type'] = "danger";
    }
    
    mysqli_close($con);
    header("Location: /HR_SYSTEM/view/Payroll/payroll.php");
    exit();
}
?>