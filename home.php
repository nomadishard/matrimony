<?php include 'connect.php';
function calculateAge($dob) {
    $today = new DateTime();
    $birthDate = new DateTime($dob);
    $age = $today->diff($birthDate);
    return $age->y;
}
session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Home</title>
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
        <style>footer {
            background-color: #2d3436;
            color: white;
            text-align: center;
            padding: 1rem;
        }</style>
    </head>

    <body>
        <header>
            <?php include 'navbar.php' ?>
        </header>
        <main>
            <section class="mt-5 ms-5 me-5">
            <form method="GET" class="mb-4">
    <div class="row g-3">
        <div class="col-md-3">
            <label for="age_min" class="form-label">Age Range</label>
            <div class="input-group">
                <input type="number" class="form-control" id="age_min" name="age_min" placeholder="Min" min="18" max="100" value="<?php echo isset($_GET['age_min']) ? htmlspecialchars($_GET['age_min']) : ''; ?>">
                <input type="number" class="form-control" id="age_max" name="age_max" placeholder="Max" min="18" max="100" value="<?php echo isset($_GET['age_max']) ? htmlspecialchars($_GET['age_max']) : ''; ?>">
            </div>
        </div>
        <div class="col-md-3">
            <label for="marital_status" class="form-label">Marital Status</label>
            <select class="form-select" id="marital_status" name="marital_status">
                <option value="">All</option>
                <option value="Single" <?php echo (isset($_GET['marital_status']) && $_GET['marital_status'] == 'Single') ? 'selected' : ''; ?>>Single</option>
                <option value="Married" <?php echo (isset($_GET['marital_status']) && $_GET['marital_status'] == 'Married') ? 'selected' : ''; ?>>Married</option>
                <option value="Divorced" <?php echo (isset($_GET['marital_status']) && $_GET['marital_status'] == 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
                <option value="Widowed" <?php echo (isset($_GET['marital_status']) && $_GET['marital_status'] == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="city" class="form-label">Current Location</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" value="<?php echo isset($_GET['city']) ? htmlspecialchars($_GET['city']) : ''; ?>">
        </div>
        <div class="col-md-2">
            <label for="city" class="form-label">Native Location</label>
            <input type="text" class="form-control" id="city" name="vill" placeholder="Enter Village" value="<?php echo isset($_GET['vill']) ? htmlspecialchars($_GET['vill']) : ''; ?>">
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Apply</button>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <a
                name=""
                id=""
                class="btn btn-primary w-100"
                href="home.php"
                role="button"
                >Reset filters</a
            >
            
        </div>
    </div>
</form>
<div
    class="row justify-content-center align-items-center g-2"
>
            <?php 
            $gen=$_SESSION['gender'];
            $sql = "SELECT * FROM profiles WHERE 1=1 AND status=1 AND gender!='$gen'";

            if (isset($_GET['age_min']) && is_numeric($_GET['age_min'])) {
                $min_date = date('Y-m-d', strtotime('-' . $_GET['age_min'] . ' years'));
                $sql .= " AND dob <= '$min_date'";
            }
            
            if (isset($_GET['age_max']) && is_numeric($_GET['age_max'])) {
                $max_date = date('Y-m-d', strtotime('-' . $_GET['age_max'] . ' years'));
                $sql .= " AND dob >= '$max_date'";
            }
            
            if (isset($_GET['marital_status']) && $_GET['marital_status'] != '') {
                $marital_status = mysqli_real_escape_string($conn, $_GET['marital_status']);
                $sql .= " AND MaritalStatus = '$marital_status'";
            }
            
            if (isset($_GET['caste']) && $_GET['caste'] != '') {
                $caste = mysqli_real_escape_string($conn, $_GET['caste']);
                $sql .= " AND caste = '$caste'";
            }
            
            if (isset($_GET['city']) && $_GET['city'] != '') {
                $city = mysqli_real_escape_string($conn, $_GET['city']);
                $sql .= " AND currentaddress LIKE '%$city%'";
            }
            
            if (isset($_GET['vill']) && $_GET['vill'] != '') {
                $vill = mysqli_real_escape_string($conn, $_GET['vill']);
                $sql .= " AND permanentaddress LIKE '%$vill%'";
            }
            
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) == 0) {
                echo '<div class="alert alert-info">No profiles found matching the selected criteria.</div>';
            }
            else{
            while($arr=mysqli_fetch_array($res)){
            $profilePicture=$arr['profile_picture'];
            $firstName=strtoupper($arr['FirstName']);
            $lastName=strtoupper($arr['LastName']);
            $dob=$arr['dob'];
            $gender=$arr['Gender'];
            $religion=$arr['Religion'];
            $maritalStatus=$arr['MaritalStatus'];
            $education=$arr['Education'];
            $occupation=$arr['Occupation'];
            $height=$arr['Height'];
            ?>
<style>
.card-img-top {
    width: 100%; /* Full width of the card */
    height: 200px; /* Fixed height */
    object-fit: contain; /* Ensures the entire image fits within the dimensions */
    object-position: center; /* Center the image in case of extra space */
}
</style>
<div class="col d-flex justify-content-center">
  <div class="card" style="width: 18rem;">
    <img src="<?php echo htmlspecialchars($profilePicture); ?>" class="card-img-top" alt="Profile Picture">
    <div class="card-body">
      <h5 class="card-title text-left"><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></h5>
      <p class="card-text text-left">
        <strong>Age:</strong> <?php echo calculateAge($dob); ?> years<br>
        <strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?><br>
        <strong>Religion:</strong> <?php echo htmlspecialchars($religion); ?><br>
        <strong>Marital Status:</strong> <?php echo htmlspecialchars($maritalStatus); ?><br>
        <strong>Education:</strong> <?php echo htmlspecialchars($education); ?><br>
        <strong>Occupation:</strong> <?php echo htmlspecialchars($occupation); ?><br>
        <strong>Height:</strong> <?php echo htmlspecialchars($height); ?> cm<br>
      </p>
      <a
          class="btn btn-primary"
          href="psdata.php?id=<?php echo $arr['ProfileID'] ?>"
          role="button"
      >View More</a>
    </div>
  </div>
</div>

    <?php } }?>
</div>


</section>
        </main>
        <footer class="mt-5">
        <p>&copy; 2024 KOKANI SHAADI.IN . All rights reserved.</p>
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
