<?php include('partial/menu.php')?>

<div class="main-content">
<div class="wrapper">
<h1>
    Manage Food 
</h1>

 
<br/>
<br/>
<?php
if(isset($_SESSION['add'])){
     echo $_SESSION['add'];
     unset($_SESSION['add']);
 }
 if(isset($_SESSION['delete'])){
     echo $_SESSION['delete'];
     unset($_SESSION['delete']);
 }
   if(isset($_SESSION['upload'])){
     echo $_SESSION['upload'];
     unset($_SESSION['upload']);
 }
 
 if(isset($_SESSION['update'])){
     echo $_SESSION['update'];
     unset($_SESSION['update']);
 }
     

 ?>

 <br/>
<br/>
 <!---button to add Food --->
 <a href="<?php  echo SITEURL?>/admin/add-food.php" class="btn-primary">Add Food</a>
<br/>
<br/>
<br/>
<br/>
<br/>
<table class="tbl-full">
    <tr>
        <th>
            S.M.
        </th>
        <th>
            title
            </th>
            
            <th>
            price
            </th>
            <th>
            image
            </th>
            <th>
                featured</th>
                <th>active</th>
                <th>action</th>

    </tr>
    <?php  
    //create sql query to display all food
    $sql="SELECT * FROM tbl_food";
    //execute the query
    $res=mysqli_query($conn,$sql);
    //count rows to check whether we have food or not
    $count=mysqli_num_rows($res);
    //create serial number variable and set default value as 1
    $sn=1;
    if($count>0){
        //we have food in database
        //get the food from database and display
        while($row=mysqli_fetch_assoc($res)){
            //get the values from individual columns
            $id=$row['id'];
            $title=$row['title'];
            $price=$row['price'];
            $image_name=$row['image_name'];
            $featured=$row['featured'];
            $active=$row['active']; ?>
    
    <tr>
         
         <td><?php echo $sn++?></td>
         <td><?php echo $title?></td>
         <td><?php echo $price?></td>
         <td>
            <?php 
            if($image_name==""){
                //display message
                echo "<div class='error'>Image not available</div>";
            }else{
                //display image
                ?>
                <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>" width="100px">
                <?php
            }
            ?>
         </td>

         <td><?php echo $featured;?></td>
         <td><?php echo $active;?></td>


        
         <td>

             <a href="<?php echo SITEURL;?>/admin/delete-food.php?id=<?php echo $id;?>" class="btn-danger">delete</a>
             <a href="<?php echo SITEURL;?>admin/update-food.php?id=<?php echo $id;?>" class="btn-secondary">Update</a>

 </td>
 
     </tr>
  
    <?php   } 
    } else{
        //food not added in database
        echo "<div class='error'>food not added</div>";
    } 
    ?> 

   
 </table>
</div>
</div>

<?php include('partial/footer.php')?>
