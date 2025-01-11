
       
       <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center ms-4" href="../home/">
                    <img src="images/navlogo.png" class="d-inline-block align-top ms-2" alt="" style="max-height: 20vh;">
                    <span style="font-family: Montserrat, sans-serif; font-weight: 800; font-style: italic; color: white;" class="ms-2">KOKANI RISHTA</span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto" style="align-items: center;">
                  <li class="nav-item active">
                    <a class="nav-link p-3" href="../home/" style="font-family: Montserrat, sans-serif;
                    font-weight: 500;
                    color: white;">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link p-3" href="../aboutus.html"  style="font-family: Montserrat, sans-serif;
                    font-weight: 500;
                    color: white;">About Us</a>
                  </li>
                  <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-family: Montserrat, sans-serif;
                font-weight: 500;
                color: white;">
          <?php
      $u = $_SESSION['user_id'];
                $sql = "SELECT * FROM profiles WHERE ProfileID=$u";
                $result = mysqli_query($conn, $sql);
                $arr = mysqli_fetch_array($result);
                $name = strtoupper($arr['FirstName']);
                $name2 = strtoupper($arr['LastName']);?>
          <?php echo $name . ' ' . $name2; ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a href="../edit/" class="dropdown-item">Edit Profile</a></li>
            <li><a href="../logout.php" class="dropdown-item">LOGOUT</a></li>
          </ul>
        </li>
                </ul>
              </div>
                </div>
            </nav>









        <style>.navbar{
          background-color: #CC2B52;
        }</style>