<?php include('partial/menu.php')?>

<div class="main-content">

<div class="wrapper">
<h1>Add Food</h1>

<br><br>
<?php 
 if(isset($_SESSION['upload'])){
     echo $_SESSION['upload'];
     unset($_SESSION['upload']);
 }
 
?>

    <form action="" method="POST" enctype="multipart/form-data">

    <table class="tbl-30">

    <tr>
        <td>Title:</td>
        <td>
            <input type="text" name="title" placeholder="Title of the food">
        </td>
    </tr>

    <tr>
        <td>Description:</td>
        <td>
            <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
        </td>
    </tr>

    <tr>
        <td>Price:</td>
        <td>
            <input type="number" name="price">
        </td>
    </tr>

    <tr>
        <td>Select Image:</td>
        <td>
            <input type="file" name="image">
        </td>
    </tr> 
    <tr>
        <td>Category:</td>
        <td>
            <select name="category">

                <?php

                    //create php code to display categories from database
                    //1. create sql to get all active categories from database
                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                    //execute the query
                    $res = mysqli_query($conn, $sql);

                    //count rows to check whether we have categories or not
                    $count = mysqli_num_rows($res); //function to get all the rows in database

                    //if count is greater than zero, we have categories else we don't have categories
                    if($count>0)
                    {
                        //we have categories
                        while($row=mysqli_fetch_assoc($res))
                        {
                            //get the details of categories
                            $id = $row['id'];
                            $title = $row['title'];

                            ?>

                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                            <?php
                        } 
                    } 
                    else
                    {
                        //we don't have categories 
                        echo "<option value='0'>Category not added</option>";
                    } 
                    ?> 
                </select>
            </td>
        </tr>
<tr>
            <td>Featured: </td>
            <td>
                <input type="radio" name="featured" value="Yes">Yes
                <input type="radio" name="featured" value="No">No
            </td>
        </tr>
        <tr>
            <td>Active: </td>
            <td>
                <input type="radio" name="active" value="Yes">Yes
                <input type="radio" name="active" value="No">No
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="submit" value="Add Food" class="btn-secondary">
            </td>
        </tr>
    </table>
</form>


<?php 
if(isset($_POST['submit'])){
    //add the food in database
    //echo "clicked";

    //1. get the data from form
    $title=$_POST['title'];
    $description=$_POST['description'];
    $price=$_POST['price'];
    $category=$_POST['category'];

    if(isset($_POST['featured'])){
        $featured=$_POST['featured'];

    }else{
        $featured="No";
    }
    if(isset($_POST['active'])){
        $active=$_POST['active'];
    }else{
            $active="No";
    }
    //2. upload the image if selected
    //check whether the select image is clicked or not and upload the image
if(isset($_FILES['image']['name'])){
        //get the details of selected image
        $image_name=$_FILES['image']['name'];
//check whether the image is selected or not and upload
        if($image_name!=""){
            //image is selected
            //A. Rename the image
            //get the extension of selected image(jpg,png,gif,etc)
            $ext=end(explode('.',$image_name));
//create new name for image
            $image_name="Food_Name_".rand(000,999).'.'.$ext;//e.g Food_Name_345.jpg 

            //B. upload the image
            $source_path=$_FILES['image']['tmp_name'];
            $destination_path="../images/food/".$image_name;
            //finally upload the image
            $upload=move_uploaded_file($source_path,$destination_path);

            //check whether the image is uploaded or not
            //and if the image is not uploaded then we will stop the process and redirect with error message
            if($upload==false){
                //set message
                $_SESSION['upload']="<div class='error'>Failed to upload image</div>";
                //redirect to add category page
                header('location:'.SITEURL.'admin/add-food.php');
                //stop the process
                die();
            }
        }
    }
    else{
        $image_name="";
            }
             
 $sql2="INSERT INTO tbl_food SET
 title='$title',
 description='$description',
 price='$price',
 image_name='$image_name',
 category_id='$category',
 featured='$featured',
 active='$active'";

 $res2=mysqli_query($conn,$sql2) or die(mysqli_error($conn));

 if($res2==true){
     $_SESSION['add']="<div class='success'>Food Added Successfully</div>";
     header('location:'.SITEURL.'admin/manage-food.php');
 }
 else{
     $_SESSION['add']="<div class='error'>Failed to Add Food</div>";
     header('location:'.SITEURL.'admin/manage-food.php');
 }  
  
        } 
?>

</div>

</div>

<?php include('partial/footer.php')?>

