<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Loan Agreement Forms</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
<body>
    <?php include 'sidebar.php'; ?>
    <div class="membership_forms_all">
     
                <div class="title">
                    <h2>Download Loan Agreement Forms</h2>
                </div>
              
             <div class="download">
                <p><a href="./files/V.ELG - Loan Agreement.pdf">Click to Download Loan Agreement</a></p>

             </div>
       
    </div>
</body>

</html>
