<?php
include 'connect.php';
$id=$_GET['id'];
$sql="UPDATE profiles set status=1 WHERE ProfileID=$id";
mysqli_query($conn,$sql);
echo"<script>
    alert('Profile Activated successfully!');
    window.location.href = 'edit.php';
</script>"


?>