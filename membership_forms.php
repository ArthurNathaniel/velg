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

// Function to output JavaScript alert and redirect
function alert($msg, $redirect = false)
{
    echo "<script type='text/javascript'>alert('$msg');";
    if ($redirect) {
        echo "window.location.href = 'view_members.php';";
    }
    echo "</script>";
}

// Function to generate next membership ID
function generateMembershipID($conn)
{
    // Query to get the maximum existing membership ID
    $sql = "SELECT MAX(SUBSTRING(membership_id, 7)) AS max_id FROM loan_membership_cards";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $next_id = intval($row['max_id']) + 1;
    } else {
        $next_id = 1; // If no records found, start from 1
    }

    // Format the next ID with leading zeros
    return "V.ELG-" . str_pad($next_id, 3, '0', STR_PAD_LEFT);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $date_joined = $_POST['date_joined'];
    $occupation = $_POST['occupation'];
    $phone_number = $_POST['phone_number'];

    // Handle profile image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        alert("File is not an image.");
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        alert("Sorry, file already exists.");
        $uploadOk = 0;
    }

    // Check file size (limit to 10 MB)
    if ($_FILES["profile_image"]["size"] > 10000000) {
        alert("Sorry, your file is too large. Maximum file size allowed is 10 MB.");
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        alert("Sorry, your file was not uploaded.");
    } else {
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            // Generate membership ID
            $membership_id = generateMembershipID($conn);

            // Prepare the SQL statement
            $sql = "INSERT INTO loan_membership_cards (name, dob, date_joined, occupation, membership_id, phone_number, profile_image)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            // Prepare and bind
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sssssss", $name, $dob, $date_joined, $occupation, $membership_id, $phone_number, $target_file);

                // Execute the statement
                if ($stmt->execute()) {
                    alert("New record created successfully", true);
                } else {
                    alert("Error: " . $sql . "" . $conn->error);
                }

                // Close the statement
                $stmt->close();
            } else {
                alert("Error preparing statement: " . $conn->error);
            }
        } else {
            alert("Sorry, there was an error uploading your file.");
        }
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Membership Card Form</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="membership_forms_all">
        <div class="members_grid">
            <div class="member_left"></div>
            <div class="member_right">
                <div class="title">
                    <h2>Loan Membership Card Form</h2>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" onsubmit="return handleSubmit()">
                    <div class="forms">
                        <label for="name">Name:</label>
                        <input type="text" placeholder="Enter your name" id="name" name="name" required>
                    </div>
                    <div class="forms">
                        <label for="dob">Date of Birth:</label>
                        <input type="text" placeholder="Pick a date" id="dob" name="dob" required>
                    </div>

                    <div class="forms">
                        <label for="date_joined">Date Joined:</label>
                        <input type="text" placeholder="Pick a date" id="date_joined" name="date_joined" required>
                    </div>

                    <div class="forms">
                        <label for="occupation">Occupation:</label>
                        <input type="text" placeholder="Enter your occupation" id="occupation" name="occupation" required>
                    </div>

                    <div class="forms">
                        <label for="membership_id">Membership ID:</label>
                        <input type="text" placeholder="The system will automatically generate the ID"  value="<?php echo isset($membership_id) ? $membership_id : ''; ?>" readonly>
                    </div>

                    <div class="forms">
                        <label for="phone_number">Phone Number:</label>
                        <input type="number" placeholder="Enter your phone number" id="phone_number" name="phone_number" required>
                    </div>

                    <div class="forms">
                        <label for="profile_image">Profile Image:</label>
                        <input type="file" id="profile_image" name="profile_image" accept="image/*" required>
                    </div>

                    <div class="forms">
                        <button type="submit" id="submitButton">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./js/swiper.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#dob, #date_joined", {
            dateFormat: "Y-m-d",
            maxDate: "today",
            disableMobile: true
        });

        function handleSubmit() {
            document.getElementById('submitButton').innerText = 'Please wait...';
            return true;
        }
    </script>
</body>

</html>
