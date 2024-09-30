<?php include('partial/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php 
            //1.get the id of selected admin
            $id=$_GET['id'];

            //2.create sql query to get the details
            $sql="SELECT * FROM tbl_admin WHERE id=$id";

            //execute the query
            $res=mysqli_query($conn,$sql);

            //count rows to check whether the id is valid or not

            if($res==true)
            {
            $count=mysqli_num_rows($res);

            if($count==1){
                $row=mysqli_fetch_assoc($res);
                $full_name=$row['full_name'];
                $username=$row['username'];
            }
            else
            {
                //redirect to manage admin page
                header('location:'.SITEURL.'admin/manage-admin.php');
            }}
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td><input type="text" name="full_name" value="<?php echo $full_name;?>"></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" value="<?php echo $username;?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            //check whether the submit button is clicked or not
            if(isset($_POST['submit']))
            {
                //echo "clicked";

                //1.get the data from form
                $id=$_POST['id'];
                $full_name=$_POST['full_name'];
                $username=$_POST['username'];

                //2.create sql query to update admin
                $sql2="UPDATE tbl_admin SET
                full_name='$full_name',
                username='$username'
                WHERE id=$id
                ";

                //execute the query
                $res2=mysqli_query($conn,$sql2);

                //check whether the query executed successfully or not
                if($res2==true)
                {
                    //echo "Admin updated";
                    //create a session variable to display message
                    $_SESSION['update']="<div class='success'>Admin updated successfully</div>";
                    //redirect to manage admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
                else
                {
                    //echo "failed to update admin";
                    //create a session variable to display message
                    $_SESSION['update']="<div class='error'>Failed to update admin</div>";
                    //redirect to manage admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        ?>
    </div>
</div>
<?php include('partial/footer.php')?>
