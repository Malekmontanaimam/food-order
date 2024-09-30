<?php include('partial/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Password</h1>

        <br><br>

        <?php 
            if(isset($_GET['id']))
            {
                // echo "getting";
                $id=$_GET['id'];
            }
            else
            {
                // echo "not getting";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Current Password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Update Password" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

        <?php 
            if(isset($_POST['submit']))
            {
                // echo "clicked";
                // 1.get the data from form
                $id=$_POST['id'];
                $current_password=md5($_POST['current_password']);
                $new_password=md5($_POST['new_password']);
                $confirm_password=md5($_POST['confirm_password']);

                // 2.check whether the user with current id and current password exists or not
                $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
                //execute the query
                $res=mysqli_query($conn,$sql);
                if($res==true)
                {
                    //check whether data is available or not
                    $count=mysqli_num_rows($res);
                    if($count==1)
                    {
                        //user exists and password can be changed
                        //check whether the new password and confirm password match or not
                        if($new_password==$confirm_password)
                        {
                            //update the password
                            //echo "password match";
                            $sql2="UPDATE tbl_admin SET
                            password='$new_password'
                            WHERE id=$id";
                            //execute the query
                            $res2=mysqli_query($conn,$sql2);
                            //check whether the query executed or not
                            if($res2==true)
                            {
                                //display success message
                                $_SESSION['change-pwd']="<div class='success'>Password Changed Successfully.</div>";
                                //redirect to manage admin page
                                header('location:'.SITEURL.'admin/manage-admin.php');
                            }
                            else
                            {
                                //display error message
                                $_SESSION['change-pwd']="<div class='error'>Failed to Change Password.</div>";
                                //redirect to manage admin page
                                header('location:'.SITEURL.'admin/manage-admin.php');
                            }
                        }
                        else
                        {
                            //display error message
                            $_SESSION['pwd-not-match']="<div class='error'>Password Did Not Match.</div>";
                            //redirect to manage admin page
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                    }
                    else
                    {
                        //user does not exist set message and redirect
                        $_SESSION['user-not-found']="<div class='error'>User Not Found.</div>";
                        //redirect to manage admin page
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
            }
        ?>

    </div>
</div>

<?php include('partial/footer.php')?>


