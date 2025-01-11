<?php
include '../connect.php';
session_start();
$id = $_SESSION['user_id'];
$sql = "SELECT * FROM profiles WHERE ProfileID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$profile = mysqli_fetch_assoc($result);

if (!$profile) {
    die("Profile not found");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assume $db is your database connection
   
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hidePicture = isset($_POST['hide_picture']) ? 1 : 0; // Check if checkbox is checked
    echo $hidePicture;
    $sql2="UPDATE profiles SET image_blur = $hidePicture WHERE ProfileID = $id";
    mysqli_query($conn,$sql2);
$firstName = trim(htmlspecialchars($_POST['FirstName'] ?? '', ENT_QUOTES, 'UTF-8'));
$middleName = trim(htmlspecialchars($_POST['middlename'] ?? '', ENT_QUOTES, 'UTF-8'));
$lastName = trim(htmlspecialchars($_POST['LastName'] ?? '', ENT_QUOTES, 'UTF-8'));
$gender = trim(htmlspecialchars($_POST['Gender'] ?? '', ENT_QUOTES, 'UTF-8'));
$dob = trim(htmlspecialchars($_POST['dob'] ?? '', ENT_QUOTES, 'UTF-8'));
$religion = trim(htmlspecialchars($_POST['Religion'] ?? '', ENT_QUOTES, 'UTF-8'));
$caste = trim(htmlspecialchars($_POST['Caste'] ?? '', ENT_QUOTES, 'UTF-8'));
$maritalStatus = trim(htmlspecialchars($_POST['MaritalStatus'] ?? '', ENT_QUOTES, 'UTF-8'));
$height = filter_var($_POST['Height'] ?? '', FILTER_VALIDATE_INT);
$weight = filter_var($_POST['Weight'] ?? '', FILTER_VALIDATE_FLOAT);
$education = trim(htmlspecialchars($_POST['Education'] ?? '', ENT_QUOTES, 'UTF-8'));
$occupation = trim(htmlspecialchars($_POST['Occupation'] ?? '', ENT_QUOTES, 'UTF-8'));
$contactNumber = trim(htmlspecialchars($_POST['ContactNumber'] ?? '', ENT_QUOTES, 'UTF-8'));
$email = filter_var($_POST['Email'] ?? '', FILTER_VALIDATE_EMAIL);
$currentAddress = trim(htmlspecialchars($_POST['currentaddress'] ?? '', ENT_QUOTES, 'UTF-8'));
$permanentAddress = trim(htmlspecialchars($_POST['permanentaddress'] ?? '', ENT_QUOTES, 'UTF-8'));
$expectation = trim(htmlspecialchars($_POST['expectation'] ?? '', ENT_QUOTES, 'UTF-8'));

// Additional validation
if (!preg_match("/^[a-zA-Z-' ]*$/", $firstName)) {
    $errors[] = "Only letters and white space allowed in First Name";
}
if (!preg_match("/^[a-zA-Z-' ]*$/", $lastName)) {
    $errors[] = "Only letters and white space allowed in Last Name";
}
if (!in_array($gender, ['Male', 'Female', 'Other'])) {
    $errors[] = "Invalid gender selection";
}
if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $dob)) {
    $errors[] = "Invalid date format for Date of Birth";
}
if (!preg_match("/^[0-9]{10}$/", $contactNumber)) {
    $errors[] = "Invalid contact number format";
}
if ($height !== false && ($height < 100 || $height > 250)) {
    $errors[] = "Height should be between 100 and 250 cm";
}
if ($weight !== false && ($weight < 30 || $weight > 200)) {
    $errors[] = "Weight should be between 30 and 200 kg";
}

    // Validate required fields
    $errors = [];
    if (!$firstName) $errors[] = "First name is required";
    if (!$lastName) $errors[] = "Last name is required";
    if (!$gender) $errors[] = "Gender is required";
    if (!$dob) $errors[] = "Date of Birth is required";
    if (!$religion) $errors[] = "Religion is required";
    if (!$maritalStatus) $errors[] = "Marital Status is required";
    if (!$height) $errors[] = "Height is required";
    if (!$weight) $errors[] = "Weight is required";
    if (!$education) $errors[] = "Education is required";
    if (!$occupation) $errors[] = "Occupation is required";
    if (!$contactNumber) $errors[] = "Contact Number is required";
    if (!$email) $errors[] = "Valid Email is required";
    if (!$currentAddress) $errors[] = "Current Address is required";
    if (!$permanentAddress) $errors[] = "Permanent Address is required";

    // If there are no errors, proceed with update
    if (empty($errors)) {
        // Handle file upload for profile picture
        $profilePicture = $profile['profile_picture']; // Keep existing picture by default
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            $uploadDir = '..uploads/'; // Ensure this directory exists and is writable
            $uploadFile = $uploadDir . basename($_FILES['profile_picture']['name']);
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            
            // Check if image file is an actual image
            $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
            if($check !== false) {
                // Allow certain file formats
                if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
                        $profilePicture = $uploadFile;
                    } else {
                        $errors[] = "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                }
            } else {
                $errors[] = "File is not an image.";
            }
        }

        if (empty($errors)) {
            // Prepare and execute UPDATE query
            $updateSql = "UPDATE profiles SET 
    FirstName = ?, middlename = ?, LastName = ?, Gender = ?, 
    dob = ?, Religion = ?, Caste = ?, MaritalStatus = ?, 
    Height = ?, Weight = ?, Education = ?, Occupation = ?, 
    ContactNumber = ?, Email = ?, currentaddress = ?, 
    permanentaddress = ?, expectation = ?, profile_picture = ? 
    WHERE ProfileID = ?";
            
            $updateStmt = mysqli_prepare($conn, $updateSql);
            mysqli_stmt_bind_param($updateStmt, "ssssssssiissssssssi", 
    $firstName, $middleName, $lastName, $gender,
    $dob, $religion, $caste, $maritalStatus,
    $height, $weight, 
    $education, $occupation,
    $contactNumber, $email, $currentAddress,
    $permanentAddress, $expectation, $profilePicture,
    $id);
            if (mysqli_stmt_execute($updateStmt)) {
                // Redirect to profile view page
                echo '<script>alert("Record Updated Successfully");</script>';
                header("Location:#");
                exit();
            } else {
                $errors[] = "Error updating record: " . mysqli_error($conn);
            }
        }
    }

   
}

?>

<!doctype html>
<html lang="en">
<head>
    <title>Edit Profile</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="logo.png" type="image/x-icon">
     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: 'Arial', sans-serif;
        }
        .profile-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .profile-picture {
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        h1 {
            color: #2c3e50;
            font-weight: bold;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        h2 {
            color: #2980b9;
            font-size: 1.8rem;
        }
        h3 {
            color: #16a085;
            font-size: 1.4rem;
            margin-top: 20px;
            border-bottom: 1px solid #16a085;
            padding-bottom: 5px;
        }
        .form-label {
            font-weight: bold;
            color: #2c3e50;
        }
        .btn-save {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-save:hover {
            background-color: #2ecc71;
        }
        footer {
            background-color: #2d3436;
            color: white;
            text-align: center;
            padding: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <?php include '../navbar.php'; ?>
    </header>
    <main class="container profile-container">
        <h1 class="mb-4 text-center">Edit Profile</h1>
        <?php
        // Display errors if any
        if (!empty($errors)) {
            echo '<div class="alert alert-danger" role="alert">';
            echo '<ul>';
            foreach ($errors as $error) {
                echo '<li>' . htmlspecialchars($error) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }
        ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
            <div class="col-md-4 text-center">
    <img src="<?php echo htmlspecialchars($profile['profile_picture']); ?>" alt="Profile Picture" class="img-fluid rounded-circle profile-picture mb-3 <?php echo $profile['image_blur'] ? 'blurred' : ''; ?>" id="profileImage">
    
    <div class="mb-3">
        <label for="profile_picture" class="form-label">Update Profile Picture</label>
        <input type="file" class="form-control" id="profile_picture" name="profile_picture">
    </div>
    
    <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="toggleBlur" <?php echo $profile['image_blur'] ? 'checked' : ''; ?> name="hide_picture">
                <label class="form-check-label" for="toggleBlur">Hide Profile Picture</label>
            </div>
</div>

<script>
document.getElementById('toggleBlur').addEventListener('change', function() {
    const profileImage = document.getElementById('profileImage');
    if (this.checked) {
        profileImage.classList.add('blurred');
    } else {
        profileImage.classList.remove('blurred');
    }
});
</script>

<style>
.blurred {
    filter: blur(5px);
}
</style>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="FirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="FirstName" name="FirstName" value="<?php echo htmlspecialchars($profile['FirstName']); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="middlename" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo htmlspecialchars($profile['middlename']); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="LastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="LastName" name="LastName" value="<?php echo htmlspecialchars($profile['LastName']); ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="Gender" class="form-label">Gender</label>
                            <select class="form-select" id="Gender" name="Gender" required>
                                <option value="Male" <?php echo $profile['Gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo $profile['Gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo $profile['Gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($profile['dob']); ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="Religion" class="form-label">Religion</label>
                            <input type="text" class="form-control" id="Religion" name="Religion" value="<?php echo htmlspecialchars($profile['Religion']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="Caste" class="form-label">Caste</label>
                            <input type="text" class="form-control" id="Caste" name="Caste" value="<?php echo htmlspecialchars($profile['Caste']); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="MaritalStatus" class="form-label">Marital Status</label>
                            <select class="form-select" id="MaritalStatus" name="MaritalStatus" required>
                                <option value="Single" <?php echo $profile['MaritalStatus'] == 'Single' ? 'selected' : ''; ?>>Single</option>
                                <option value="Married" <?php echo $profile['MaritalStatus'] == 'Married' ? 'selected' : ''; ?>>Married</option>
                                <option value="Divorced" <?php echo $profile['MaritalStatus'] == 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                                <option value="Widowed" <?php echo $profile['MaritalStatus'] == 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="Height" class="form-label">Height (cm)</label>
                            <input type="number" class="form-control" id="Height" name="Height" value="<?php echo htmlspecialchars($profile['Height']); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="Weight" class="form-label">Weight (kg)</label>
                            <input type="number" class="form-control" id="Weight" name="Weight" value="<?php echo htmlspecialchars($profile['Weight']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="Education" class="form-label">Education</label>
                        <input type="text" class="form-control" id="Education" name="Education" value="<?php echo htmlspecialchars($profile['Education']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="Occupation" class="form-label">Occupation</label>
                        <input type="text" class="form-control" id="Occupation" name="Occupation" value="<?php echo htmlspecialchars($profile['Occupation']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ContactNumber" class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" id="ContactNumber" name="ContactNumber" value="<?php echo htmlspecialchars($profile['ContactNumber']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="Email" name="Email" value="<?php echo htmlspecialchars($profile['Email']); ?>" required>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <label for="currentaddress" class="form-label">Current Address</label>
                    <textarea class="form-control" id="currentaddress" name="currentaddress" rows="3" required><?php echo htmlspecialchars($profile['currentaddress']); ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="permanentaddress" class="form-label">Permanent Address</label>
                    <textarea class="form-control" id="permanentaddress" name="permanentaddress" rows="3" required><?php echo htmlspecialchars($profile['permanentaddress']); ?></textarea>
                </div>
            </div>
            <div class="mb-3">
                <label for="expectation" class="form-label">Expectations</label>
                <textarea class="form-control" id="expectation" name="expectation" rows="4"><?php echo htmlspecialchars($profile['expectation']); ?></textarea>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn" style="background-color: #CC2B52;color:white">Save Changes</button>
            </div>
        </form>
        <?php 
if ($profile['status'] == 1) {
    echo '
    <form action="../deactivate/" method="POST" style="display:inline;">
        <input type="hidden" name="id" value="'.$id.'">
        <button type="submit" class="btn btn-warning" role="button">Deactivate Profile</button>
    </form>';
} else if ($profile['status'] == 2) {
    echo '
    <form action="../activate/" method="POST" style="display:inline;">
        <input type="hidden" name="id" value="'.$id.'">
        <button type="submit" class="btn btn-success" role="button">Activate Profile</button>
    </form>';
}
?>
       
        
    </main>
    <footer>
        <p>&copy; 2024 KOKANIRISHTA.IN . All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
