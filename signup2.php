<?php
// Include the database connection file
include 'connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize it
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $middleName = mysqli_real_escape_string($conn, $_POST['middleName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $religion = mysqli_real_escape_string($conn, $_POST['religion']);
    $caste = mysqli_real_escape_string($conn, $_POST['caste']);
    $maritalStatus = mysqli_real_escape_string($conn, $_POST['maritalStatus']);
    $height = mysqli_real_escape_string($conn, $_POST['height']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $education = mysqli_real_escape_string($conn, $_POST['education']);
    $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
    $contactNumber = mysqli_real_escape_string($conn, $_POST['contactNumber']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Hashing the password
    $currentAddress = mysqli_real_escape_string($conn, $_POST['currentAddress']);
    $permanentAddress = mysqli_real_escape_string($conn, $_POST['permanentAddress']);
    $expectations=mysqli_real_escape_string($conn,$_POST['expectations']);

    $checkEmailQuery = "SELECT * FROM profiles WHERE Email='$email'";
    $result = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($result) > 0) {
        // Email already exists
        echo '<script>alert("Email already exists. Please use a different email.");
       window.history.back();
        </script>';
    } else {
    // Handle file upload for profile picture
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
        $targetDir = "uploads/"; // Specify your upload directory
        $targetFile = $targetDir . basename($_FILES["profilePicture"]["name"]);
        move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFile);
        $profilePicturePath = mysqli_real_escape_string($conn, $targetFile);
    } else {
        // Set a default image or handle error
        $profilePicturePath = null; // Or set a default image path
    }

    // SQL query to insert data into profiles table
    $sql = "INSERT INTO profiles (FirstName, middlename, LastName, Gender, dob, Religion, Caste,
            MaritalStatus, Height, Weight, Education, Occupation,
            ContactNumber, Email, password, currentAddress,
            permanentAddress, profile_picture,expectation)
            VALUES ('$firstName', '$middleName', '$lastName', '$gender', '$dob', '$religion', 
            '$caste', '$maritalStatus', '$height', '$weight', '$education', 
            '$occupation', '$contactNumber', '$email', '$password', 
            '$currentAddress', '$permanentAddress', '$profilePicturePath','$expectations')";

    // Execute the query and check for success

    if (mysqli_query($conn, $sql)) {
        echo '<script>
                alert("Profile created successfully");
                window.location.href ="login.html";
              </script>';
    } else {
        echo '<script>
               alert("Profile NOT created");
              </script>';
    }

    // Close the database connection
    mysqli_close($conn);
}}
?>
