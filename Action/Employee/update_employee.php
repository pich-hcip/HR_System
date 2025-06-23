<?php
session_start();
include_once '../../Config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_id = mysqli_real_escape_string($con, $_POST['EmpId']);
    $full_name = mysqli_real_escape_string($con, $_POST['EmpName']);
    $sex = mysqli_real_escape_string($con, $_POST['Sex']);
    $dob = mysqli_real_escape_string($con, $_POST['DOB']);
    $pob = mysqli_real_escape_string($con, $_POST['POB']);
    $email = mysqli_real_escape_string($con, $_POST['Email']);
    $phone_number = mysqli_real_escape_string($con, $_POST['PhoneNumber']);
    $dep_id = mysqli_real_escape_string($con, $_POST['DepId']);
    $pos_id = mysqli_real_escape_string($con, $_POST['PosId']);
    $stat_id = mysqli_real_escape_string($con, $_POST['StatId']);
    $join_date = mysqli_real_escape_string($con, $_POST['JoinDate']);
    $address = mysqli_real_escape_string($con, $_POST['Address']);

    // Validate
    if (
        empty($emp_id) || empty($full_name) || empty($email) || 
        empty($dep_id) || empty($pos_id) || empty($stat_id) || empty($join_date)
    ) {
        die("Please fill in all required fields.");
    }

    // Update query
    $sql = "UPDATE employee SET
                EmpName = ?,
                Sex = ?,
                DOB = ?,
                POB = ?,
                Email = ?,
                PhoneNumber = ?,
                DepId = ?,
                PosId = ?,
                StatId = ?,
                JoinDate = ?,
                Address = ?
            WHERE EmpId = ?";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssssss",
        $full_name, $sex, $dob, $pob, $email, $phone_number,
        $dep_id, $pos_id, $stat_id, $join_date, $address, $emp_id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: /HR_SYSTEMME/view/Employee/employee.php?success=Employee updated successfully");
        exit();
    } else {
        echo "Update failed: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}

mysqli_close($con);
?>
