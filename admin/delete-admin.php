<?php
$id=$_GET['id'];
include('../config/constants.php');
$sql="DELETE FROM tbl_admin WHERE id=$id";
$res=mysqli_query($conn,$sql);
if($res==true)
{
  
    $_SESSION['delete']="<div class='success'>Admin Deleted Successfully</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');
}else{
   $_SESSION['delete']="<div class='error'>Failed to Delete Admin</div>";
   header('location:'.SITEURL.'admin/manage-admin.php'); 
}
?>