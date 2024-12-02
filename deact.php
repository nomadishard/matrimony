<?php
include 'connect.php';
$id=$_GET['id'];
$sql="UPDATE profiles set status=2 WHERE ProfileID=$id";
mysqli_query($conn,$sql);
echo"<script>
    alert('Profile deactivated successfully!');
    window.location.href = 'edit.php';
</script>"


?>