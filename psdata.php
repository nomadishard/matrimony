<?php
include 'connect.php';
session_start();
$id = $_POST['id'];
$sql = "SELECT * FROM profiles WHERE ProfileID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$profile = mysqli_fetch_assoc($result);

if (!$profile) {
    die("Profile not found");
}

// Check if the user has already requested contact details
$user_id = $_SESSION['user_id'] ?? 0; // Assuming you have a user session
$request_sql = "SELECT * FROM contact_requests WHERE requester_id = ? AND profile_id = ?";
$request_stmt = mysqli_prepare($conn, $request_sql);
mysqli_stmt_bind_param($request_stmt, "ii", $user_id, $id);
mysqli_stmt_execute($request_stmt);
$request_result = mysqli_stmt_get_result($request_stmt);
$existing_request = mysqli_fetch_assoc($request_result);

// Handle contact request submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_contact'])) {
    if (!$existing_request) {
        $insert_sql = "INSERT INTO contact_requests (requester_id, profile_id, status) VALUES (?, ?, 'pending')";
        $insert_stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($insert_stmt, "ii", $user_id, $id);
        mysqli_stmt_execute($insert_stmt);
        $existing_request = ['status' => 'pending'];
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Profile Details</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="logo.png" type="image/x-icon">
     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        footer {
            background-color: #2d3436;
            color: white;
            text-align: center;
            padding: 1rem;
        }
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
        .table {
            margin-top: 20px;
        }
        .table th {
            background-color: #ecf0f1;
            color: #2c3e50;
            font-weight: bold;
        }
        .address-box, .expectations-box {
            background-color: #f1f8e9;
            border-radius: 10px;
            padding: 15px;
            margin-top: 10px;
        }
        .btn-edit {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-edit:hover {
            background-color: #2980b9;
        }
    </style>
    <style>
        /* ... (previous styles remain the same) ... */
        .contact-request {
            margin-top: 20px;
            padding: 15px;
            background-color: #e8f5e9;
            border-radius: 10px;
            text-align: center;
        }
        .btn-request {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-request:hover {
            background-color: #45a049;
        }
        .request-status {
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <?php  include 'navbar.php'; ?>
    </header>
    <main class="container profile-container">
        <h1 class="mb-4 text-center">Profile Details</h1>
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="<?php echo htmlspecialchars($profile['profile_picture']); ?>" alt="Profile Picture" class="img-fluid rounded-circle profile-picture mb-3 <?php echo $profile['image_blur'] ? 'blurred' : ''; ?>">
            </div>
            <style>
.blurred {
    filter: blur(5px);
}
</style>
            <div class="col-md-8">
                <h2 
                style="color:#CC2B52"><?php echo strtoupper(htmlspecialchars($profile['FirstName'] . ' ' . $profile['middlename'] . ' ' . $profile['LastName'])); ?></h2>
                <table class="table table-hover">
                    <tr>
                        <th>Gender</th>
                        <td><?php echo htmlspecialchars($profile['Gender']); ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td><?php echo htmlspecialchars($profile['dob']); ?></td>
                    </tr>
                    <tr>
                        <th>Religion</th>
                        <td><?php echo htmlspecialchars($profile['Religion']); ?></td>
                    </tr>
                    <tr>
                        <th>Caste</th>
                        <td><?php echo htmlspecialchars($profile['Caste']); ?></td>
                    </tr>
                    <tr>
                        <th>Marital Status</th>
                        <td><?php echo htmlspecialchars($profile['MaritalStatus']); ?></td>
                    </tr>
                    <tr>
                        <th>Height</th>
                        <td><?php echo htmlspecialchars($profile['Height']),' cm'; ?></td>
                    </tr>
                    <tr>
                        <th>Weight</th>
                        <td><?php echo htmlspecialchars($profile['Weight']),' kg'; ?></td>
                    </tr>
                    <tr>
                        <th>Education</th>
                        <td><?php echo htmlspecialchars($profile['Education']); ?></td>
                    </tr>
                    <tr>
                        <th>Occupation</th>
                        <td><?php echo htmlspecialchars($profile['Occupation']); ?></td>
                    </tr>
                </table>
                <div class="contact-request">
                    <?php if (!$existing_request): ?>
                        <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                            <button type="submit" name="request_contact" class="btn btn-request">Request Contact Details</button>
                        </form>
                    <?php else: ?>
                        <div class="request-status">
                            <?php
                            switch ($existing_request['status']) {
                                case 'pending':
                                    echo "Your request is pending admin approval.";
                                    break;
                                case 'approved':
                                    echo "Your request has been approved. Contact details: <br>";
                                    echo "Phone: " . htmlspecialchars($profile['ContactNumber']) . "<br>";
                                    echo "Email: " . htmlspecialchars($profile['Email']);
                                    break;
                                case 'rejected':
                                    echo "Your request has been rejected.";
                                    break;
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <h3>Current Town</h3>
                <div class="address-box">
                    <p><?php echo nl2br(htmlspecialchars($profile['currentaddress'])); ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <h3>Home Town</h3>
                <div class="address-box">
                    <p><?php echo nl2br(htmlspecialchars($profile['permanentaddress'])); ?></p>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <h3>Expectations</h3>
                <div class="expectations-box">
                    <p><?php echo nl2br(htmlspecialchars($profile['expectation'])); ?></p>
                </div>
            </div>
        </div>
    </main>
    <footer style="background-color: #CC2B52;">
        <p>&copy; 2024 KOKANIRISHTA.IN . All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
