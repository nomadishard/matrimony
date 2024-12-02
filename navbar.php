<nav class="navbar navbar-light" style="border-bottom:solid">
<a class="navbar-brand" href="home.php">
              <img src="KOKAN_CONNECT.png" class="d-inline-block align-top" alt="" style="max-height: 20vh;">
          </a>
  <ul class="navbar-nav me-4">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            <li><a href="edit.php" class="dropdown-item">Edit Profile</a></li>
            <li><a href="logout.php" class="dropdown-item">LOGOUT</a></li>
          </ul>
        </li>
        </ul>
</nav>