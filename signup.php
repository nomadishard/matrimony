<?php 
include 'connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $religion = $_POST['religion'];
    $caste = $_POST['caste'];
    $maritalStatus = $_POST['maritalStatus'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $education = $_POST['education'];
    $occupation = $_POST['occupation'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $currentAddress = $_POST['currentAddress'];
    $permanentAddress = $_POST['permanentAddress'];
    $expectations = $_POST['expectations'];
    $pass=$_POST['pass'];


    // Handle file upload
    $profilePicture = '';
    if(isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profilePicture"]["name"]);
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
            $profilePicture = $target_file;
        }
    }

    // Prepare SQL statement
    $sql = "INSERT INTO profiles (firstName, middlename, lastName, Gender, dob, Religion, Caste, MaritalStatus, Height, Weight, Education, Occupation, ContactNumber, Email, currentaddress, permanentaddress, profile_picture, expectation,password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssddsssssssss", $firstName, $middleName, $lastName, $gender, $dob, $religion, $caste, $maritalStatus, $height, $weight, $education, $occupation, $contactNumber, $email, $currentAddress, $permanentAddress, $profilePicture, $expectations,$pass);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
    alert('Profile created successfully!');
    window.location.href = 'login.html';
</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement
    $stmt->close();
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Signup</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
    <header>
        <nav class="navbar navbar-light" style="border-bottom:solid">
          <a class="navbar-brand" href="index.html">
              <img src="KOKAN_CONNECT.png" class="d-inline-block align-top" alt="" style="max-height: 20vh;">
          </a>
          <a href="login.html" class="ms-auto nav-link">LOGIN</a>
        </nav>
    </header>
        <main>
        <style>
  
  .form-container {
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
    margin-top: 20px;
  }
  
  .form-title {
    color: #007bff;
    font-weight: bold;
    margin-bottom: 30px;
    text-align: center;
  }
  
  .form-label {
    font-weight: 600;
    color: #495057;
  }
  
  .form-control, .form-select {
    border-radius: 8px;
  }
  
  .form-control:focus, .form-select:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
  }
  
  .btn-submit {
    background-color: #007bff;
    border-color: #007bff;
    border-radius: 8px;
    padding: 10px 30px;
    font-weight: bold;
    transition: all 0.3s ease;
  }
  
  .btn-submit:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }
  
  .form-section {
    background-color: #f1f3f5;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
  }
  
  .form-section-title {
    color: #007bff;
    font-weight: bold;
    margin-bottom: 15px;
  }
</style>

<div class="container form-container">
  <h2 class="form-title">Personal Information Form</h2>
  <form class="needs-validation" novalidate method="post" action="#" enctype="multipart/form-data">
    <div class="form-section">
      <h4 class="form-section-title">Basic Information</h4>
      <div class="row g-3">
        <div class="col-md-4">
          <label for="firstName" class="form-label">First name</label>
          <input type="text" class="form-control" id="firstName" name="firstName"  required>
          <div class="invalid-feedback">Please provide a first name.</div>
        </div>
        <div class="col-md-4">
          <label for="middleName" class="form-label">Middle name</label>
          <input type="text" class="form-control" id="middleName" name="middleName">
        </div>
        <div class="col-md-4">
          <label for="lastName" class="form-label">Last name</label>
          <input type="text" class="form-control" id="lastName" required name="lastName">
          <div class="invalid-feedback">Please provide a last name.</div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-4">
          <label for="gender" class="form-label">Gender</label>
          <select class="form-select" id="gender" required name="gender">
            <option value="">Choose...</option>
            <option>Male</option>
            <option>Female</option>
          </select>
          <div class="invalid-feedback">Please select a gender.</div>
        </div>
        <div class="col-md-4">
          <label for="dob" class="form-label">Date of Birth</label>
          <input type="date" class="form-control" id="dob" required name="dob">
          <div class="invalid-feedback">Please provide a valid date of birth.</div>
        </div>
        <div class="col-md-4">
          <label for="religion" class="form-label">Religion</label>
          <input type="text" class="form-control" id="religion" name="religion">
        </div>
      </div>
    </div>

    <div class="form-section">
      <h4 class="form-section-title">Additional Details</h4>
      <div class="row g-3">
        <div class="col-md-4">
          <label for="caste" class="form-label">Caste(if any)</label>
          <input type="text" class="form-control" id="caste" name="caste">
        </div>
        <div class="col-md-4">
          <label for="maritalStatus" class="form-label">Marital Status</label>
          <select class="form-select" id="maritalStatus" required name="maritalStatus">
            <option value="">Choose...</option>
            <option>Single</option>
            <option>Married</option>
            <option>Divorced</option>
            <option>Widowed</option>
          </select>
          <div class="invalid-feedback">Please select a marital status.</div>
        </div>
        <div class="col-md-2">
          <label for="height" class="form-label">Height (cm)</label>
          <input type="number" class="form-control" id="height" required name="height">
          <div class="invalid-feedback">Please provide a valid height.</div>
        </div>
        <div class="col-md-2">
          <label for="weight" class="form-label">Weight (kg)</label>
          <input type="number" class="form-control" id="weight" required name="weight">
          <div class="invalid-feedback">Please provide a valid weight.</div>
        </div>
      </div>
    </div>

    <div class="form-section">
      <h4 class="form-section-title">Professional Information</h4>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="education" class="form-label">Education</label>
          <input type="text" class="form-control" id="education" required name="education">
          <div class="invalid-feedback">Please provide your education details.</div>
        </div>
        <div class="col-md-6">
          <label for="occupation" class="form-label">Occupation</label>
          <input type="text" class="form-control" id="occupation" required name="occupation">
          <div class="invalid-feedback">Please provide your occupation.</div>
        </div>
      </div>
    </div>

    <div class="form-section">
      <h4 class="form-section-title">Contact Information</h4>
      <div class="row g-3">
        <div class="col-md-4">
          <label for="contactNumber" class="form-label">Contact Number</label>
          <input type="tel" class="form-control" id="contactNumber" required name="contactNumber">
          <div class="invalid-feedback">Please provide a valid contact number.</div>
        </div>
        <div class="col-md-4">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" required name="email">
          <div class="invalid-feedback">Please provide a valid email address.</div>
        </div>
        <div class="col-md-4">
          <label for="pass" class="form-label">Password</label>
          <input type="text" class="form-control" id="pass" required name="pass">
        </div>
      </div>

      <div class="mt-3">
        <label for="currentAddress" class="form-label">Current Address</label>
        <textarea class="form-control" id="currentAddress" rows="3" required name="currentAddress"></textarea>
        <div class="invalid-feedback">Please provide your current address.</div>
      </div>

      <div class="mt-3">
        <label for="permanentAddress" class="form-label">Native Address</label>
        <textarea class="form-control" id="permanentAddress" rows="3" required name="permanentAddress"></textarea>
        <div class="invalid-feedback">Please provide your permanent address.</div>
      </div>
    </div>

    <div class="form-section">
      <h4 class="form-section-title">Profile Picture</h4>
      <div>
        <label for="profilePicture" class="form-label">Upload Picture</label>
        <input type="file" class="form-control" id="profilePicture" accept="image/*" required name="profilePicture">
        <div class="invalid-feedback">Please upload a profile picture.</div>
      </div>
      <div class="mt-3">
  <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 200px; display: none;">
</div>

<script>
document.getElementById('profilePicture').addEventListener('change', function(event) {
  var file = event.target.files[0];
  var imagePreview = document.getElementById('imagePreview');
  
  if (file) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      imagePreview.src = e.target.result;
      imagePreview.style.display = 'block';
    }
    
    reader.readAsDataURL(file);
  } else {
    imagePreview.src = '#';
    imagePreview.style.display = 'none';
  }
});
</script>
    </div>

    <div class="form-section">
    <h4 class="form-section-title">Expectations</h4>
    <div>
        <label for="expectations" class="form-label">Your Expectations</label>
        <textarea class="form-control" id="expectations" rows="3" name="expectations"></textarea>
    </div>
</div>

<!-- New Terms and Conditions Section -->
<div class="form-section mt-4">
    <h4 class="form-section-title">Terms and Conditions</h4>
    <div>
        <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
        <label for="agreeTerms" class="form-label">
            I agree to the <a href="terms.html" target="_blank">terms and conditions</a>.
        </label>
    </div>
</div>

<div class="mt-4 text-center">
    <button class="btn btn-primary btn-submit" type="submit">Submit Form</button>
</div>

  </form>
</div>

<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
</script>
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
