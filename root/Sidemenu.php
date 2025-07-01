<!DOCTYPE html>
<html>
<head>
<?php
    include("header.php");
?>
    <!-- Google Fonts - Professional font combination -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&family=Noto+Sans+Khmer:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="Style/sidemenu.css">
</head>
<body>
    <div class="menu">
        <!-- <div class="brand-logo">
            <img src="../assets/images/yrm-logo.png" alt="YRM">
        </div> -->
        <div class="menu-search">
            <input type="text" placeholder="Search menu..." class="form-control">
        </div>
        <ul class="list-unstyled components">
            <li>
                <a href="../view/Dashboard/dashboard.php" target="content">
                    <i class="fa fa-home"></i>Dasborad
                </a>
            </li>
            
            <li>
                <a href="../view/Employee/employee.php" target="content" >
                    <i class=" fa fa-users"></i><span lang="km">Employee</span>
                </a>
                
            </li>

            <li>
                <a href="../view/Payroll/payroll.php"  target="content">
                    <i class=" fa fa-money-bill"></i><span lang="km">Payroll</span>
                </a>
               
            </li>
                
            <li>
                <a href="#User" data-toggle="collapse" target="content">
                    <i class="fa fa-book"></i><span lang="km">Leave Report</span>
                </a>
                
               
            </li>

            <li>
                <a href="#Report" data-toggle="collapse" target="content">
                    <i class="fa fa-cog"></i><span lang="km">Setting</span>
                </a>
                
            </li>
        </ul>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>