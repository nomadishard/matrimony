<?php
include '../connect.php';
$id=$_POST['id'];
$sql="UPDATE profiles set status=1 WHERE ProfileID=$id";
session_start();
$_SESSION['status']=1;
mysqli_query($conn,$sql);
echo"<script>
    alert('Profile Activated successfully!');
    window.location.href = '../edit/';
</script>"


?>