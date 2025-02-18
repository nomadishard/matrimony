<?php
include 'connect.php';
session_start();
$id = $_SESSION['user_id'];
$sql = "SELECT * FROM profiles WHERE ProfileID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$profile = mysqli_fetch_assoc($result);

if (!$profile) {
    echo '<script>
        window.location.href = "/home/";
    </script>';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql2 = "update profiles set delstat=1 where ProfileID=$id";
    if (mysqli_query($conn, $sql2)) {
        header("location:logout.php");
        exit();
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
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .profile-picture {
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
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
        <?php include 'navbar.php'; ?>
    </header>
    <main class="container profile-container">
        <h1 class="mb-4 text-center">Delete Profile</h1>
        <form method="POST" enctype="multipart/form-data">
            <style>
                .blurred {
                    filter: blur(5px);
                }
            </style>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="FirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="FirstName" name="FirstName" value="<?php echo htmlspecialchars($profile['FirstName']); ?>" required disabled>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="middlename" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo htmlspecialchars($profile['middlename']); ?>" disabled>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="LastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="LastName" name="LastName" value="<?php echo htmlspecialchars($profile['LastName']); ?>" required disabled>
                    </div>
                </div>
                <div
                    class="row justify-content-center align-items-center">
                    <div class="row justify-content-center align-items-center">
                        <div class="col align-items-center justify-content-center">
                            <button type="submit" class="btn btn-danger" onclick="return confirmDelete()">Delete Data</button>
                        </div>
                    </div>

                    <script>
                        function confirmDelete() {
                            return confirm("Are you sure you want to delete your profile? This action cannot be undone.");
                        }
                    </script>
                    <style>
                        .btn-danger {
                            background-color: #e74c3c;
                            color: white;
                            border: none;
                            padding: 10px 20px;
                            border-radius: 5px;
                            font-weight: bold;
                            transition: background-color 0.3s, transform 0.3s;
                        }

                        .btn-danger:hover {
                            background-color: #c0392b;
                            transform: scale(1.05);
                        }
                    </style>
                </div>


    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>