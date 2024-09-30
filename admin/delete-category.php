<?php
$id=$_GET['id'];
include('../config/constants.php');
$sql="DELETE FROM tbl_category WHERE id=$id";
$res=mysqli_query($conn,$sql);
if($res==true)
{
  
    $_SESSION['delete']="<div class='success'>Gategory Deleted Successfully</div>";
    header('location:'.SITEURL.'admin/manage-category.php');
}else{
   $_SESSION['delete']="<div class='error'>Failed to Delete Gategory</div>";
   header('location:'.SITEURL.'admin/manage-category.php'); 
}