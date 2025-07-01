<?php
session_start();
require_once '../../Config/connect.php';

// Fetch all payroll data with employee names
$payroll_query = "SELECT p.*, e.EmpName 
                 FROM payroll p
                 JOIN employee e ON p.EmpId = e.EmpId
                 ORDER BY p.PayId DESC";
$payroll_result = mysqli_query($con, $payroll_query);
$payrollData = mysqli_fetch_all($payroll_result, MYSQLI_ASSOC);

// Fetch employees for dropdown
$employees_query = "SELECT EmpId, EmpName FROM employee ORDER BY EmpName";
$employees_result = mysqli_query($con, $employees_query);
$employees = mysqli_fetch_all($employees_result, MYSQLI_ASSOC);

// Close connection
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payroll Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .total-salary {
            font-weight: bold;
            color: #2a6496;
        }

        .modal {
            z-index: 1060;
            /* Higher than other elements */
        }
    </style>
</head>

<body class="p-4 bg-light">
    <div class="container-fluid">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['message_type']) ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary"><i class="bi bi-cash-stack"></i> Payroll Management</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPayrollModal">
                <i class="bi bi-plus-circle"></i> Add New Payroll
            </button>
        </div>

        <!-- Payroll Table -->
        <div class="table-responsive rounded-3 shadow-sm bg-white">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Pay ID</th>
                        <th>Employee</th>
                        <th class="text-end">Basic Salary</th>
                        <th class="text-end">Bonus</th>
                        <th class="text-end total-salary">Total Salary</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($payrollData)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No payroll records found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($payrollData as $payroll):
                            $totalSalary = (float)$payroll['BasicSalary'] + (float)$payroll['Bonus'];
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($payroll['PayId']) ?></td>
                                <td>
                                    <div><?= htmlspecialchars($payroll['EmpName']) ?></div>
                                </td>
                                <td class="text-end"><?= number_format((float)$payroll['BasicSalary'], 2) ?></td>
                                <td class="text-end"><?= number_format((float)$payroll['Bonus'], 2) ?></td>
                                <td class="text-end total-salary"><?= number_format($totalSalary, 2) ?></td>
                                <td class="text-nowrap">
                                    <button type="button" class="btn btn-primary btn-sm btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editPayrollModal"
                                        data-pay-id="<?= htmlspecialchars($payroll['PayId']) ?>"
                                        data-emp-id="<?= htmlspecialchars($payroll['EmpId']) ?>"
                                        data-emp-name="<?= htmlspecialchars($payroll['EmpName']) ?>"
                                        data-basic-salary="<?= htmlspecialchars($payroll['BasicSalary']) ?>"
                                        data-bonus="<?= htmlspecialchars($payroll['Bonus']) ?>"
                                        aria-label="Edit payroll record">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                    <a href="/HR_SYSTEM/Action/Payroll/deletePayroll.php?PayId=<?= htmlspecialchars($payroll['PayId']) ?>"
                                        onclick="return confirm('Are you sure you want to delete this payroll record?');"
                                        class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Payroll Modal -->
    <div class="modal fade" id="addPayrollModal" tabindex="-1" aria-labelledby="addPayrollModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../../Action/Payroll/addPayroll.php" method="POST">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addPayrollModalLabel">Add New Payroll</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addEmpId" class="form-label">Employee</label>
                            <select class="form-select" id="addEmpId" name="EmpId" required>
                                <option value="" selected disabled>Select Employee</option>
                                <?php foreach ($employees as $employee): ?>
                                    <option value="<?= htmlspecialchars($employee['EmpId']) ?>">
                                        <?= htmlspecialchars($employee['EmpName']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addBasicSalary" class="form-label">Basic Salary</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control" id="addBasicSalary" name="BasicSalary" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="addBonus" class="form-label">Bonus</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control" id="addBonus" name="Bonus" value="0.00" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Payroll</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Payroll Modal -->
    <div class="modal fade" id="editPayrollModal" tabindex="-1" aria-labelledby="editPayrollModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../../Action/Payroll/editPayroll.php" method="POST">
                    <input type="hidden" id="editPayId" name="PayId">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="editPayrollModalLabel">Edit Payroll</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Employee</label>
                            <input type="text" class="form-control" id="editEmpName" readonly>
                            <input type="hidden" id="editEmpId" name="EmpId">
                        </div>
                        <div class="mb-3">
                            <label for="editBasicSalary" class="form-label">Basic Salary</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control" id="editBasicSalary" name="BasicSalary" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editBonus" class="form-label">Bonus</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control" id="editBonus" name="Bonus" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Update Payroll</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deletePayrollModal" tabindex="-1" aria-labelledby="deletePayrollModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../../Controller/Payroll/deletePayroll.php" method="POST">
                    <input type="hidden" id="deletePayId" name="PayId">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deletePayrollModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this payroll record? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle edit button clicks to populate the edit modal
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const payId = this.getAttribute('data-pay-id');
                const empId = this.getAttribute('data-emp-id');
                const empName = this.getAttribute('data-emp-name');
                const basicSalary = this.getAttribute('data-basic-salary');
                const bonus = this.getAttribute('data-bonus');

                document.getElementById('editPayId').value = payId;
                document.getElementById('editEmpId').value = empId;
                document.getElementById('editEmpName').value = empName;
                document.getElementById('editBasicSalary').value = basicSalary;
                document.getElementById('editBonus').value = bonus;
            });
        });

        // Handle delete button clicks to populate the delete modal
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const payId = this.getAttribute('data-pay-id');
                document.getElementById('deletePayId').value = payId;

                // Show the delete confirmation modal
                const deleteModal = new bootstrap.Modal(document.getElementById('deletePayrollModal'));
                deleteModal.show();
            });
        });
    </script>
</body>

</html>