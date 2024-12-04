<?php
include 'connect.php';
?>
<!doctype html>
<html lang="en">

<head>
  <title>Signup</title>
  <link rel="stylesheet" href="nav2.css">
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
    crossorigin="anonymous" />
  <link rel="icon" href="logo.png" type="image/x-icon">

</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand d-flex align-items-center ms-4" href="index.html">
        <img src="images/navlogo.png" class="d-inline-block align-top ms-2" alt="" style="max-height: 20vh;">
        <span style="font-family: Montserrat, sans-serif; font-weight: 800; font-style: italic; color: white;" class="ms-2">KOKAN RISHTA</span>
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item active">
            <a class="nav-link p-3" href="index.html" style="font-family: Montserrat, sans-serif;
                    font-weight: 500;
                    color: white;">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link p-3" href="#" style="font-family: Montserrat, sans-serif;
                    font-weight: 500;
                    color: white;">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link p-3" href="login.html" style="font-family: Montserrat, sans-serif;
                    font-weight: 500;
                    color: white;">Login</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <main>
    <style>
      .form-container {
        background-color: #E8F0CE;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-top: 20px;
        position: relative;
        background-color: rgba(255, 255, 255, 0.5);
        /* White with 50% opacity */
        backdrop-filter: blur(10px);

      }

      .form-title {
        color: #E44B70;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: center;
      }

      .form-label {
        font-weight: 600;
        color: #495057;
      }

      .form-control,
      .form-select {
        border-radius: 8px;
      }

      .form-control:focus,
      .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
      }

      .btn-submit {
        background-color: #CC2B52;
        border-radius: 8px;
        border: none;
        padding: 10px 30px;
        font-weight: bold;
        transition: all 0.3s ease;
      }

      .btn-submit:hover {
        background-color: #AF1740;
        border-color: #0056b3;
      }

      .form-section {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
      }

      .form-section-title {
        color: #E44B70;
        font-weight: bold;
        margin-bottom: 15px;
      }
    </style>

    <div class="container form-container mb-5">
      <h2 class="form-title">Personal Information Form</h2>
      <form class="needs-validation" novalidate method="post" action="signup2.php" enctype="multipart/form-data">
        <div class="form-section">
          <h4 class="form-section-title">Basic Information</h4>
          <div class="row g-3">
            <div class="col-md-4">
              <label for="firstName" class="form-label">First name</label>
              <input type="text" class="form-control" id="firstName" name="firstName" required>
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
              <div id="ageValidationMessage" style="color: red;"></div>
            </div>

            <script>
              document.getElementById("dob").addEventListener("change", validateAge);

              function validateAge() {
                const dobInput = document.getElementById("dob").value;
                const messageElement = document.getElementById("ageValidationMessage");

                if (!dobInput) {
                  messageElement.textContent = "Please enter your date of birth.";
                  return; // Exit if no date is entered
                }

                const dob = new Date(dobInput);
                const today = new Date();
                const age = today.getFullYear() - dob.getFullYear();
                const monthDifference = today.getMonth() - dob.getMonth();

                // Check if the user is 18 or older
                if (age > 18 || (age === 18 && monthDifference > 0) || (age === 18 && monthDifference === 0 && today.getDate() >= dob.getDate())) {
                  messageElement.textContent = ""; // Clear any previous messages
                  // You can add additional logic here for when age is valid
                } else {
                  messageElement.textContent = "You must be at least 18 years old.";
                }
              }
            </script>

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
              <input type="tel" class="form-control" id="contactNumber" required name="contactNumber" maxlength="10">
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
      (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
          .forEach(function(form) {
            form.addEventListener('submit', function(event) {
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
  <footer class="footer">
    <p style="background: #72001F;color: white;padding-bottom: 0px;margin-bottom: 0px;text-align: center;
">&copy; 2024 KOKANRISHTA.IN . All rights reserved.</p>
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
</body>

</html>
<form method="POST" action="controller/UserController.php" enctype="multipart/form-data">
  <!-- Form fields here... -->
</form>
