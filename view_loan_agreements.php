<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Directory where uploaded files are stored
$upload_dir = "uploads/";

// Scan the directory for files
$files = array_diff(scandir($upload_dir), array('.', '..'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Loan Agreements</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/view_member.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="view_membership_forms_all">
        <div class="title">
            <h2>View Loan Agreements</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($files)) {
                    foreach ($files as $file) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($file); ?></td>
                            <td><a href="<?php echo $upload_dir . htmlspecialchars($file); ?>" download>Download</a></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="2">No loan agreement files found.</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
