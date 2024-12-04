<?php
include 'connect.php';
session_start();

// Check if the user is logged in and is an admin

    if($_SESSION['role']!=1){
    header("Location: home.php");
    exit();}

// Handle approve/reject actions for contact requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['request_id'])) {
        $request_id = $_POST['request_id'];
        $action = $_POST['action'];
        $sql = "UPDATE contact_requests SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $action, $request_id);
        mysqli_stmt_execute($stmt);
    }

    // Handle profile approval
    if (isset($_POST['profile_id'])) {
        $profile_id = $_POST['profile_id'];
        $sql = "UPDATE profiles SET status = 1 WHERE ProfileID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $profile_id);
        mysqli_stmt_execute($stmt);
    }
}

// Fetch pending requests
$sql = "SELECT cr.id, cr.requester_id, cr.profile_id, cr.request_timestamp, 
               u.FirstName AS requester_name, 
               p.FirstName AS profile_name
        FROM contact_requests cr
        JOIN profiles u ON cr.requester_id = u.ProfileID
        JOIN profiles p ON cr.profile_id = p.ProfileID
        WHERE cr.status = 'pending'
        ORDER BY cr.request_timestamp DESC";

$result = mysqli_query($conn, $sql);

// Fetch new user profiles pending approval
$sql_profiles = "SELECT ProfileID, FirstName FROM profiles WHERE status = 0";
$result_profiles = mysqli_query($conn, $sql_profiles);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Contact Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 20px; }
        .request-card { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Pending Contact Requests</h1>
        
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="card request-card">
                    <div class="card-body">
                        <h5 class="card-title">Request #<?php echo $row['id']; ?></h5>
                        <p class="card-text">
                            <strong>Requester:</strong> <?php echo htmlspecialchars($row['requester_name']); ?><br>
                            <strong>Profile:</strong> <?php echo htmlspecialchars($row['profile_name']); ?><br>
                            <strong>Requested on:</strong> <?php echo $row['request_timestamp']; ?>
                        </p>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="action" value="approved" class="btn btn-success">Approve</button>
                            <button type="submit" name="action" value="rejected" class="btn btn-danger">Reject</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No pending requests.</p>
        <?php endif; ?>

        <h2 class="mt-5">Pending User Profiles</h2>

        <?php if (mysqli_num_rows($result_profiles) > 0): ?>
            <?php while ($profile_row = mysqli_fetch_assoc($result_profiles)): ?>
                <div class="card request-card">
                    <div class="card-body">
                        <h5 class="card-title">Profile ID: <?php echo $profile_row['ProfileID']; ?></h5>
                        <p class="card-text">
                            <strong>Name:</strong> <?php echo htmlspecialchars($profile_row['FirstName']); ?><br>
                        </p>
                        <form id="detailsForm" action="psdata.php" method="post" style="display: none;">
    <input type="hidden" name="id" value="<?php echo $profile_row['ProfileID']; ?>">
</form>
                        
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="profile_id" value="<?php echo $profile_row['ProfileID']; ?>">
                            <button type="submit" name="action" value="approve_profile" class="btn btn-success">Approve Profile</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No pending user profiles.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
