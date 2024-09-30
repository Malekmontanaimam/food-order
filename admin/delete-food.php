<?php
$id=$_GET['id'];
include('../config/constants.php');
$sql="DELETE FROM tbl_food WHERE id=$id";
$res=mysqli_query($conn,$sql);
if($res==true)
{
  
    $_SESSION['delete']="<div class='success'>Food Deleted Successfully</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}else{
   $_SESSION['delete']="<div class='error'>Failed to Delete food</div>";
   header('location:'.SITEURL.'admin/manage-food.php'); 
}