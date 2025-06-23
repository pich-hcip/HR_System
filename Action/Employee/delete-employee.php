<?php
session_start();
include_once '../../Config/connect.php';

// Check if user is logged in and has appropriate permissions
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    header("Location: /HR_SYSTEMME/View/Auth/login.php?error=UnauthorizedAccess");
    exit();
}

// Check if EmpId exists in GET request and is numeric
if (!isset($_GET['EmpId']) || !ctype_digit($_GET['EmpId'])) {
    header("Location: /HR_SYSTEMME/View/Employee/employee.php?error=InvalidEmployeeID");
    exit();
}

$empId = (int)$_GET['EmpId'];

// Prepare and execute the delete query with parameterized statement
$sql = "DELETE FROM employee WHERE EmpId = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $empId);
$result = mysqli_stmt_execute($stmt);

// Close statement
mysqli_stmt_close($stmt);

// Redirect based on success or failure
if ($result) {
    header("Location: /HR_SYSTEMME/View/Employee/employee.php?success=EmployeeDeleted");
} else {
    header("Location: /HR_SYSTEMME/View/Employee/employee.php?error=DeleteFailed");
}
exit();
?>