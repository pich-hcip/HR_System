<?php
session_start();
include_once '../../Config/connect.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['message'] = "Invalid request method.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../../View/Employee/employee.php");
    exit();
}

// Check if all required fields are set
$requiredFields = [
    'EmpId', 'EmpName', 'Sex', 'DOB', 'POB', 'Email', 
    'PhoneNumber', 'DepId', 'PosId', 'StatId', 'JoinDate', 'Address'
];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field])) {
        $_SESSION['message'] = "Missing required field: $field";
        $_SESSION['message_type'] = "danger";
        header("Location: ../../View/Employee/employee.php");
        exit();
    }
}

// Sanitize and validate input data
$EmpId = mysqli_real_escape_string($con, trim($_POST['EmpId']));
$EmpName = mysqli_real_escape_string($con, trim($_POST['EmpName']));
$Sex = mysqli_real_escape_string($con, trim($_POST['Sex']));
$DOB = mysqli_real_escape_string($con, trim($_POST['DOB']));
$POB = mysqli_real_escape_string($con, trim($_POST['POB']));
$Email = mysqli_real_escape_string($con, trim($_POST['Email']));
$PhoneNumber = mysqli_real_escape_string($con, trim($_POST['PhoneNumber']));
$DepId = mysqli_real_escape_string($con, trim($_POST['DepId']));
$PosId = mysqli_real_escape_string($con, trim($_POST['PosId']));
$StatId = mysqli_real_escape_string($con, trim($_POST['StatId']));
$JoinDate = mysqli_real_escape_string($con, trim($_POST['JoinDate']));
$Address = mysqli_real_escape_string($con, trim($_POST['Address']));

// Validate Sex (only M or F allowed)
if (!in_array($Sex, ['M', 'F'])) {
    $_SESSION['message'] = "Invalid value for Sex.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../../View/Employee/employee.php");
    exit();
}

// Validate email format
if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "Invalid email format.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../../View/Employee/employee.php");
    exit();
}

// Check if employee exists
$checkQuery = "SELECT EmpId FROM employee WHERE EmpId = '$EmpId'";
$checkResult = mysqli_query($con, $checkQuery);

if (mysqli_num_rows($checkResult) === 0) {
    $_SESSION['message'] = "Employee not found.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../../View/Employee/employee.php");
    exit();
}

// Prepare the update query
$updateQuery = "
    UPDATE employee 
    SET 
        EmpName = '$EmpName',
        Sex = '$Sex',
        DOB = '$DOB',
        POB = '$POB',
        Email = '$Email',
        PhoneNumber = '$PhoneNumber',
        DepId = '$DepId',
        PosId = '$PosId',
        StatId = '$StatId',
        JoinDate = '$JoinDate',
        Address = '$Address'
    WHERE 
        EmpId = '$EmpId'
";

// Execute the update query
if (mysqli_query($con, $updateQuery)) {
    $_SESSION['message'] = "Employee updated successfully.";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Error updating employee: " . mysqli_error($con);
    $_SESSION['message_type'] = "danger";
}

// Close the database connection
mysqli_close($con);

// Redirect back to the employee page
header("Location: ../../View/Employee/employee.php");
exit();
?>