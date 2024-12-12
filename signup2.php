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
    $password = password_hash($_POST['pass'],PASSWORD_DEFAULT);
     // Hashing the password
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
    if (isset($_POST['croppedImage'])) {
        // Get the Data URL from the POST request
        $dataUrl = $_POST['croppedImage'];
    
        // Check if the Data URL is valid
        if (preg_match('/^data:image\/(\w+);base64,/', $dataUrl, $type)) {
            // Remove the header from the Data URL
            $data = substr($dataUrl, strpos($dataUrl, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif
    
            // Decode the base64 data
            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new \Exception('Invalid type');
            }
    
            $data = base64_decode($data);
            if ($data === false) {
                throw new \Exception('Base64 decode failed');
            }
    
            // Specify your upload directory
            $targetDir = "uploads/";
            // Generate a unique filename to prevent overwriting
            $fileName = uniqid() . '.' . $type;
            $targetFile = $targetDir . $fileName;
    
            // Save the image file
            if (file_put_contents($targetFile, $data) !== false) {
                // Successfully saved the file
                $profilePicturePath = mysqli_real_escape_string($conn, $targetFile);
                echo json_encode(['success' => true, 'path' => $profilePicturePath]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save image.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid data URL.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No image data received.']);
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
               window.location.href ="index.html";
              </script>';
    }

    // Close the database connection
    mysqli_close($conn);
}}
?>
