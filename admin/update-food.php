<?php include('partial/menu.php')?>

<?php 
//check whether id is set or not
if(isset($_GET['id']))
{
    //get the id and all other details
    //echo "getting the data";
    $id=$_GET['id'];
    //create sql query to get all the details
    $sql="SELECT * FROM tbl_food WHERE id=$id";
    //execute the query
    $res=mysqli_query($conn,$sql);
    
    //count the rows to check whether the id is valid or not
  
        //get the details
        $row=mysqli_fetch_assoc($res);
        $title=$row['title'];
        $description=$row['description'];
        $price=$row['price'];
        $current_image=$row['image_name'];
        $category_id=$row['category_id'];
        $featured=$row['featured'];
        $active=$row['active'];
}
    else
    {
        //redirect to manage food
        header('location:'.SITEURL.'admin/manage-food.php');
    }


?>



<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" value="<?php echo $title;?>">
                </td>
            </tr>
            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description;?></textarea>
                </td>
            </tr>
            <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price" value="<?php echo $price;?>">
                </td>
            </tr>
            <tr>
                <td>Current Image:</td>
                <td>
                    <?php 
                    if($current_image=="")
                    {
                        echo "<div class='error'>Image not available</div>";
                    }
                    else
                    {
                        ?>
                        <img src="<?php echo SITEURL;?>images/food/<?php echo $current_image;?>" width="100px">
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Select New Image:</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            <tr>
                <td>Category:</td>
                <td>
                    <select name="category">
                        <?php 
                        //create sql query to get all the categories from database
                        $sql2="SELECT * FROM tbl_category WHERE active='Yes'";
                        //execute the query
                        $res2=mysqli_query($conn,$sql2);
                        //count rows to check whether we have categories or not
                        $count2=mysqli_num_rows($res2);
                        //if count is greater than zero, we have categories else we don't have categories
                        if($count2>0)
                        {
                            //we have categories
                            while($row2=mysqli_fetch_assoc($res2))
                            {
                                $category_title=$row2['title'];
                                $category_id=$row2['id'];
                                ?>
                                <option <?php if($category_id==$category_id) {echo "selected";}?> value="<?php echo $category_id;?>"><?php echo $category_title;?></option>
                                <?php
                            }
                        }
                        else
                        {
                            //we don't have categories
                            ?>
                            <option value="0">No Category Found</option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                    <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                </td>
            </tr>
            <tr>
                <td>Active:</td>
                <td>
                    <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                    <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>
    <?php 
        //check whether the submit button is clicked or not
        if(isset($_POST['submit']))
        {
            //echo "clicked";
            //1. get all the details from form
            $id=$_POST['id'];
            $title=$_POST['title'];
            $description=$_POST['description'];
            $price=$_POST['price'];
            $current_image=$_POST['current_image'];
            $category=$_POST['category'];
            $featured=$_POST['featured'];
            $active=$_POST['active'];
            //2. upload the image if selected
            //check whether the select image is clicked or not
            if(isset($_FILES['image']['name']))
            {
                //get the image details
                $image_name=$_FILES['image']['name'];
                //check whether the image is available or not
                if($image_name!="")
                {
                    //image available
                     //A. upload the new image
                    //auto rename our image
                    //get the extension of our image(jpg,png,gif,etc)
                    $ext=end(explode('.',$image_name));
                    //rename the image
                    $image_name="Food_Name_".rand(000,999).'.'.$ext; //e.g. Food_Name_345.jpg
                    
                    $source_path=$_FILES['image']['tmp_name'];
                    $destination_path="../images/food/".$image_name;
                    //finally upload the image
                    $upload=move_uploaded_file($source_path,$destination_path);
                    //check whether the image is uploaded or not
                    //and if the image is not uploaded then we will stop the process and redirect with error message
                    if($upload==false)
                    {
                        //set message
                        $_SESSION['upload']="<div class='error'>Failed to upload image</div>";
                        //redirect to add food page
                        header('location:'.SITEURL.'admin/manage-food.php');
                        //stop the process
                        die();
                    }
                    //B. remove the current image if available
                    if($current_image!="")
                    {
                        $remove_path="../images/food/".$current_image;
                        $remove=unlink($remove_path);
                        //check whether the image is removed or not
                        //and if the image is not removed then display message and stop the process
                        if($remove==false)
                        {
                            //failed to remove image
                            $_SESSION['remove']="<div class='error'>Failed to remove current image</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die();
                        }
                    }
                }
                else
                {
                    $image_name=$current_image;
                }
            }
           
            
            //3. update the food in database
            $sql2="UPDATE tbl_food SET
            title='$title',
            description='$description',
            price=$price,
            image_name='$image_name',
            category_id='$category',
            featured='$featured',
            active='$active'
            WHERE id=$id
            ";
            //execute the query
            $res2=mysqli_query($conn,$sql2);
            
            //4. redirect to manage food with message(success/error)
            //check whether the query executed or not and update the food or not
            if($res2==true)
            {
                //food updated
                $_SESSION['update']="<div class='success'>Food Updated Successfully</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                //failed to update food
                $_SESSION['update']="<div class='error'>Failed to Update Food</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }

        
        
            }
            
    
    ?>
    </div></div>


<?php include('partial/footer.php')?>
