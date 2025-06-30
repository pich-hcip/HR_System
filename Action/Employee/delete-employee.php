<?php
session_start();
include_once '../../Config/connect.php';

// Check if EmpId is provided
if (isset($_GET['EmpId'])) {
    $empId = $_GET['EmpId'];
    
    // Prepare delete statement
    $sql = "DELETE FROM employee WHERE EmpId = ?";
    $stmt = mysqli_prepare($con, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $empId);
        $result = mysqli_stmt_execute($stmt);
        
        if ($result) {
            $_SESSION['message'] = "Employee deleted successfully";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error deleting employee: " . mysqli_error($con);
            $_SESSION['message_type'] = "danger";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = "Error preparing statement: " . mysqli_error($con);
        $_SESSION['message_type'] = "danger";
    }
} else {
    $_SESSION['message'] = "Employee ID not provided";
    $_SESSION['message_type'] = "danger";
}

// Redirect back to employee list
header("Location: /HR_SYSTEM/view/Employee/employee.php");
exit();
?>