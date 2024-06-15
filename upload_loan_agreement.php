<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Handle file upload if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Directory where uploaded files will be saved
    $upload_dir = "loans_files/";

    // Check if file was uploaded without errors
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["file"]["tmp_name"];
        $file_name = basename($_FILES["file"]["name"]);
        $target_file = $upload_dir . $file_name;

        // Move uploaded file to target location
        if (move_uploaded_file($tmp_name, $target_file)) {
            // File upload successful
            echo "<script>alert('File uploaded successfully.'); window.location.href = 'upload_loan_agreement.php';</script>";
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.location.href = 'upload_loan_agreement.php';</script>";
        }
    } else {
        echo "<script>alert('Error uploading file.'); window.location.href = 'upload_loan_agreement.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Loan Agreement</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="upload_form">
        <div class="title">
            <h2>Upload Loan Agreement</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="forms">
                <label for="file">Select File:</label>
                <input type="file" id="file" name="file" accept=".pdf" required>
            </div>
            <div class="forms">
                <button type="submit">Upload File</button>
            </div>
        </form>
    </div>

    <script src="./js/swiper.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize any additional JavaScript functionality here
    </script>
</body>
</html>
