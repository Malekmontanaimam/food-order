
<?php 

include('../config/constants.php');

?>
<html>
    <head>
        <title>Login -Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body >
 <div class="imag">
<div class="login" >
    <h1 style="text-align: center" >Login</h1>
    <br/>
    <?php
    if(isset($_SESSION['login'])){
        echo $_SESSION['login'];
        unset($_SESSION['login']);
    }
   if(isset($_SESSION['no-login-message'])){
        echo $_SESSION['no-login-message'];
        unset($_SESSION['no-login-message']);
    }
    ?>
    <br/>
    <br/>
    <form action="" method="post" style="text-align: center">
        <label for="username">Username</label><br/>
        <input type="text" name="username" id="username" placeholder="Enter your username" required><br/>
        <label for="password">Password</label><br/>
        <input type="password" name="password" id="password" placeholder="Enter your password" required><br/>
        <br/> <input type="submit" name="submit" value="Login" class="btn-primary"><br/>
    </form>
    <br/><br/>
    <p style="text-align: center">Created by-<a href="#">Malekimama</a></p>
</div></div>
    </body>
    </head>
</html>
<?php
    
    if(isset($_POST['submit'])){
        
        $username=$_POST['username'];
        $password=md5($_POST['password']);
        $sql="SELECT * FROM  tbl_admin WHERE username='$username' AND password='$password'";
        $result=mysqli_query($conn,$sql);
        $count=mysqli_num_rows($result);
        if($count==1){
            $_SESSION['login']="<div class='success'>Login Successful</div>";
            $_SESSION['user']=$username;//To check whether the user is logged in or not and logout will unset it
            header('location:'.SITEURL.'admin/');
        }
        else{
            $_SESSION['login']="<div class='error ' style='text-align: center'>Username or Password is incorrect</div>";
            header('location:'.SITEURL.'admin/Login.php');
        }
        }
      
    
    


?>