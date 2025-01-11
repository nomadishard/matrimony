<?php
include '../connect.php';
$id=$_POST['id'];
$sql="UPDATE profiles set status=2 WHERE ProfileID=$id";
session_start();
$_SESSION['status']=2;
mysqli_query($conn,$sql);
echo"<script>
    alert('Profile deactivated successfully!');
    window.location.href = '../edit/';
</script>"


?>