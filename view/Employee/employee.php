<?php
session_start();
include_once '../../Config/connect.php';

// Fetch all employees
$sql = "
        SELECT 
            e.EmpId,
            e.EmpName,
            e.Sex,
            e.DOB,
            e.POB,
            e.Email,
            e.PhoneNumber,
            d.DepName AS Department,
            p.Position AS Position,
            s.Status AS Status,
            e.JoinDate,
            e.Address
        FROM employee e
        LEFT JOIN department d ON e.DepId = d.DepId
        LEFT JOIN position p ON e.PosId = p.PosId
        LEFT JOIN status s ON e.StatId = s.StatId
        ORDER BY e.EmpId ASC";

$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Employees Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4 bg-light">

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Employees</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                Add New
            </button>
        </div>

        <!-- Employees Table -->
        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr class="text-nowrap">
                    <th>Emp ID</th>
                    <th>Full Name</th>
                    <th>Sex</th>
                    <th>DOB</th>
                    <th>POB</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Join Date</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="text-nowrap">
                            <td><?php echo htmlspecialchars($row['EmpId']); ?></td>
                            <td><?php echo htmlspecialchars($row['EmpName']); ?></td>
                            <td><?php echo htmlspecialchars($row['Sex']); ?></td>
                            <td><?php echo htmlspecialchars($row['DOB']); ?></td>
                            <td><?php echo htmlspecialchars($row['POB']); ?></td>
                            <td><?php echo htmlspecialchars($row['Email']); ?></td>
                            <td><?php echo htmlspecialchars($row['PhoneNumber']); ?></td>
                            <td><?php echo htmlspecialchars($row['Department']); ?></td>
                            <td><?php echo htmlspecialchars($row['Position']); ?></td>
                            <td><?php echo htmlspecialchars($row['Status']); ?></td>
                            <td><?php echo htmlspecialchars($row['JoinDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['Address']); ?></td>
                            <td>
                                <!-- Edit Button (could open modal or link to edit page) -->
                                <a href="EmpId=<?php echo urlencode($row['EmpId']); ?>" class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editEmployeeModal">
                                    Edit
                                </a>


                                <a href="delete_employee.php?EmpId=<?php echo urlencode($row['EmpId']); ?>" 
                                    onclick="return confirm('Are you sure you want to delete this employee?');"
                                    class="btn btn-sm btn-danger">
                                    Delete
                                </a>

                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="text-center">No employees found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Employee Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="/HR_SYSTEM/Action/Employee/EmpController.php">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold" id="addEmployeeModalLabel">Add New Employee</h5>
                        <button type="button" class="btn btn-danger btn-sm btn-close" data-bs-dismiss="modal"></button>

                    </div>
                    <div class="modal-body fw-bold">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Emp ID</label>
                                <input type="text" name="EmpId" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="EmpName" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sex</label>
                                <select name="Sex" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">DOB</label>
                                <input type="date" name="DOB" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Place of Birth</label>
                                <input type="text" name="POB" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="Email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="PhoneNumber" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department</label>
                                <select name="DepId" class="form-control" required>
                                    <option value="">Select Department</option>
                                    <?php
                                    $dep_query = "SELECT DepId, DepName FROM department";
                                    $dep_result = mysqli_query($con, $dep_query);

                                    if ($dep_result && mysqli_num_rows($dep_result) > 0) {
                                        while ($dep = mysqli_fetch_assoc($dep_result)) {
                                            echo '<option value="' . htmlspecialchars($dep['DepId']) . '">' . htmlspecialchars($dep['DepName']) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                 <label class="form-label">Position</label>
                                <select name="PosId" class="form-control" required>
                                    <option value="">Select Position</option>
                                    <?php
                                    $pos_query = "SELECT PosId, Position FROM position";
                                    $pos_result = mysqli_query($con, $pos_query);

                                    if ($dep_result && mysqli_num_rows($dep_result) > 0) {
                                        while ($pos = mysqli_fetch_assoc($pos_result)) {
                                            echo '<option value="' . htmlspecialchars($pos['PosId']) . '">' . htmlspecialchars($pos['Position']) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                 <label class="form-label">Status</label>
                                <select name="StatId" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <?php
                                  $sta_query = "SELECT StatId, Status FROM status WHERE StatId IN (1, 3)";
                                    $sta_result = mysqli_query($con, $sta_query);

                                    if ($sta_result && mysqli_num_rows($sta_result) > 0) {
                                        while ($sta = mysqli_fetch_assoc($sta_result)) {
                                            echo '<option value="' . htmlspecialchars($sta['StatId']) . '">' . htmlspecialchars($sta['Status']) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Join Date</label>
                                <input type="date" name="JoinDate" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea name="Address" class="form-control" rows="2" required></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" action="/HR_SYSTEMME/Action/Employee/update_employee.php" id="editEmployeeForm">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title fw-bold" id="editEmployeeModalLabel">Edit Employee</h5>
          <button type="button" class="btn btn-danger btn-sm btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body fw-bold">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Emp ID</label>
              <!-- EmpId is readonly to avoid change -->
              <input type="text" name="EmpId" id="editEmpId" class="form-control" readonly required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Full Name</label>
              <input type="text" name="EmpName" id="editEmpName" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Sex</label>
              <select name="Sex" id="editSex" class="form-control" required>
                <option value="">Select</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">DOB</label>
              <input type="date" name="DOB" id="editDOB" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Place of Birth</label>
              <input type="text" name="POB" id="editPOB" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="Email" id="editEmail" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone Number</label>
              <input type="text" name="PhoneNumber" id="editPhoneNumber" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Department</label>
              <select name="DepId" id="editDepId" class="form-control" required>
                <option value="">Select Department</option>
                <?php
                $dep_query = "SELECT DepId, DepName FROM department";
                $dep_result = mysqli_query($con, $dep_query);
                if ($dep_result && mysqli_num_rows($dep_result) > 0) {
                    while ($dep = mysqli_fetch_assoc($dep_result)) {
                        echo '<option value="' . htmlspecialchars($dep['DepId']) . '">' . htmlspecialchars($dep['DepName']) . '</option>';
                    }
                }
                ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Position</label>
              <select name="PosId" id="editPosId" class="form-control" required>
                <option value="">Select Position</option>
                <?php
                $pos_query = "SELECT PosId, Position FROM position";
                $pos_result = mysqli_query($con, $pos_query);
                if ($pos_result && mysqli_num_rows($pos_result) > 0) {
                    while ($pos = mysqli_fetch_assoc($pos_result)) {
                        echo '<option value="' . htmlspecialchars($pos['PosId']) . '">' . htmlspecialchars($pos['Position']) . '</option>';
                    }
                }
                ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Status</label>
              <select name="StatId" id="editStatId" class="form-control" required>
                <option value="">Select Status</option>
                <?php
                $sta_query = "SELECT StatId, Status FROM status WHERE StatId IN (1, 3)";
                $sta_result = mysqli_query($con, $sta_query);
                if ($sta_result && mysqli_num_rows($sta_result) > 0) {
                    while ($sta = mysqli_fetch_assoc($sta_result)) {
                        echo '<option value="' . htmlspecialchars($sta['StatId']) . '">' . htmlspecialchars($sta['Status']) . '</option>';
                    }
                }
                ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Join Date</label>
              <input type="date" name="JoinDate" id="editJoinDate" class="form-control" required>
            </div>
            <div class="col-12">
              <label class="form-label">Address</label>
              <textarea name="Address" id="editAddress" class="form-control" rows="2" required></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>