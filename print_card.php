<?php
// Include the database connection file
include('db.php');

// Validate and sanitize input
$member_id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : null;

if ($member_id) {
    // Query to select member details by ID
    $stmt = $conn->prepare("SELECT * FROM loan_membership_cards WHERE id = ?");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Display member details in a print-friendly format
        echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Print Membership Card</title>
     <link rel='stylesheet' href='./css/base.css'>
      <link rel='stylesheet' href='./css/print.css'>
</head>
<body>
    <div class='all'>
    <div class='mark'>
        <h2>V.ELG Membership Card</h2>
        <div class='card_img'>
        <img src='" . $row["profile_image"] . "' alt='Member Image'>
            </div>
    <div class='flex-details'>
        <p><strong>Name:</strong> " . $row["name"] . "</p>
        <p><strong>Date of Birth:</strong> " . $row["dob"] . "</p>
        <p><strong>Date Joined:</strong> " . $row["date_joined"] . "</p>
        <p><strong>Occupation:</strong> " . $row["occupation"] . "</p>
        <p><strong>Membership ID:</strong> " . $row["membership_id"] . "</p>
        <p><strong>Phone Number:</strong> " . $row["phone_number"] . "</p>
        </div>
            <div class='barcode'>
        <img src='./images/barcode.png'>
         </div>
         </div>
    </div>
        <script>
            // Automatically trigger the print dialog when the page is loaded
            window.onload = function() {
                window.print();
            }
        </script>
    </div>
</body>
</html>";
    } else {
        echo "Member not found";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid member ID";
}
