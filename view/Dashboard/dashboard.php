<!DOCTYPE html>
<html lang="en">
<?php
session_start();

if (isset($_COOKIE['remember'])) {
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $_COOKIE['remember'];
} elseif (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <h1>Welcome to dashboard <?php echo $_SESSION['username']?></h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit maxime numquam dolorem doloremque voluptas quisquam provident doloribus placeat obcaecati. Recusandae assumenda, expedita beatae iure tempore qui provident in dolore eaque?</p>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
         // Make this function available in the global scope
         function showAlertInContent() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to logout from the system!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to logout script or login page
                    window.location.href = 'logout.php'; // or your login page
                }
            });
        }
        
        // Alternatively, you can attach the event listener to the button if it exists in this document
        document.addEventListener('DOMContentLoaded', function() {
            var logoutBtn = document.getElementById('logoutBtn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', showAlertInContent);
            }
        });
    </script>
</body>
</html>