<?php
session_start();
require_once '../../Config/connect.php';

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_id = mysqli_real_escape_string($con, trim($_POST['EmpId']));
    $full_name = mysqli_real_escape_string($con, trim($_POST['EmpName']));
    $sex = mysqli_real_escape_string($con, trim($_POST['Sex']));
    $dob = mysqli_real_escape_string($con, trim($_POST['DOB']));
    $pob = mysqli_real_escape_string($con, trim($_POST['POB']));
    $email = mysqli_real_escape_string($con, trim($_POST['Email']));
    $phone_number = mysqli_real_escape_string($con, $_POST['PhoneNumber']);
    $dep_id = mysqli_real_escape_string($con, trim($_POST['DepId']));
    $pos_id = mysqli_real_escape_string($con, trim($_POST['PosId']));
    $join_date = mysqli_real_escape_string($con, trim($_POST['JoinDate']));
    $stat_id = mysqli_real_escape_string($con, trim($_POST['StatId']));
    $address = mysqli_real_escape_string($con, trim($_POST['Address']));

    if (!$emp_id || empty($full_name) || empty($email) || empty($dep_id) || empty($pos_id) || empty($join_date)) {
        die("Please fill all required fields correctly.");
    }

    // Optional: Check for duplicate EmpId
    $check = mysqli_query($con, "SELECT 1 FROM employee WHERE EmpId = '$emp_id'");
    if (mysqli_num_rows($check) > 0) {
        die("Employee ID '$emp_id' already exists.");
    }

    // Insert into employee table using actual IDs
    $sql = "INSERT INTO employee 
        (EmpId, EmpName, Sex, DOB, POB, Email, PhoneNumber, DepId, PosId, StatId, JoinDate, Address)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssssss", 
        $emp_id, $full_name, $sex, $dob, $pob, $email, $phone_number, 
        $dep_id, $pos_id, $stat_id, $join_date, $address);

    if (mysqli_stmt_execute($stmt)) {
        header("Location:/HR_SYSTEM/view/Employee/employee.php?success=Employee added successfully");
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
