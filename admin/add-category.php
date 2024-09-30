<?php
 include('partial/menu.php')
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>
        <?php 
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
            if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>
        <br><br>
        
        <form action="" method="POST" enctype="multipart/form-data">
 <table class="tbl-30">
    <tr>
        <td>Title:</td>
        <td>
            <input type="text" name="title" placeholder="Category Title">
        </td>
    </tr>
    <tr>
        <td>Select Image:</td>
        <td>
            <input type="file" name="image">
        </td>
    </tr>
    <tr>
        <td>Featured:</td>
        <td>
            <input type="radio" name="featured" value="Yes">Yes
            <input type="radio" name="featured" value="No">No
        </td>
    </tr>
    <tr>
        <td>Active:</td>
        <td>
            <input type="radio" name="active" value="Yes">Yes
            <input type="radio" name="active" value="No">No
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
        </td>
    </tr>

 </table></form>
   <?php
      if(isset($_POST['submit']))
        {
            // echo "Clicked";

            // 1. Get the value from category form
            $title=$_POST['title'];
    if(isset($_POST['featured']))
    {
        $featured=$_POST['featured'];
    }
    else
    {
        $featured="No";
    }
    if(isset($_POST['active']))
    {
        $active=$_POST['active'];
    }
    else
    {
        $active="No";
    }
           
            // 2. Upload the image if selected
            // Check whether the image is selected or not
            if(isset($_FILES['image']['name']))
            {
                // Get the Image details
                $image_name=$_FILES['image']['name'];
$sourcepat=$_FILES['image']['tmp_name'];

if($image_name!=""){


$ext=end(explode('.',$image_name));

// Rename the Image
$image_name="Food_Category_".rand(000,999).'.'.$ext;
$destination_path="../images/category/".$image_name;

// Upload the Image
$upload=move_uploaded_file($sourcepat,$destination_path);

// Check whether the image is uploaded or not
// And if the image is not uploaded then we will stop the process and redirect with error message
if($upload==false)
{
    // Set Message
    $_SESSION['upload']="<div class='error'>Failed to Upload Image</div>";
    // Redirect to Add Category Page
    header('location:'.SITEURL.'admin/add-category.php');
    // Stop the Process
    die();
}

}
            }
            else
            {
                // Don't Upload the Image and set the image_name value as blank
                $image_name="";
                // Check whether the image is available or not
            
            }

      
            //  3. Insert into Database
            // Create SQL to insert into database
            $sql2="INSERT INTO tbl_category SET
            title='$title',
            image_name='$image_name',
            featured='$featured',
            active='$active'
            ";

            // Execute the Query
            $res2=mysqli_query($conn,$sql2);

            // Check whether the query executed or not and data added or not
            if($res2==true)
            {
                // Query Executed and Category Added
                $_SESSION['add']="<div class='success'>Category Added Successfully</div>";
                // Redirect to Manage Category Page
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {
                // Failed to Add Category
                $_SESSION['add']="<div class='error'>Failed to Add Category</div>";
                // Redirect to Manage Category Page
                header('location:'.SITEURL.'admin/add-category.php');
            }

               // 4. Redirect to Manage Category with Message (Success/Error)
        }  
               
   ?>
    </div>
</div>   

<?php
 include('partial/footer.php')
?>