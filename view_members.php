<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Include the database connection file
include('db.php');

// Query to select all members
$sql = "SELECT * FROM loan_membership_cards ORDER BY id DESC";
$result = $conn->query($sql);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Members - Loan Membership Card</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/view_member.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="view_membership_forms_all">
        <div class="title">
            <h2>View Members - Loan Membership Card</h2>
        </div>

        <?php if ($result && $result->num_rows > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Date Joined</th>
                        <th>Occupation</th>
                        <th>Membership ID</th>
                        <th>Phone Number</th>
                        <th>Profile Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["dob"]; ?></td>
                            <td><?php echo $row["date_joined"]; ?></td>
                            <td><?php echo $row["occupation"]; ?></td>
                            <td><?php echo $row["membership_id"]; ?></td>
                            <td><?php echo $row["phone_number"]; ?></td>
                            <td><img src='<?php echo $row["profile_image"]; ?>' style='max-width: 100px; max-height: 100px;'></td>
                            <td><a href='print_card.php?id=<?php echo $row["id"]; ?>' class='print-button'>Print Card</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No members found</p>
            <!-- Optionally, you can provide a link to add new members or other relevant actions -->
        <?php endif; ?>
    </div>

</body>
</html>
