
<?php include('partial/menu.php') ?>

<!------------menu section end---------->

<!------------main content section---------->
<div class="main-content">
<div class="wrapper">
<h1>
    DASHBOARD
</h1>
<?php
    if(isset($_SESSION['login'])){
        echo $_SESSION['login'];
        unset($_SESSION['login']);
    }
  
    ?>
    <br/>
    <br/>
 <div class="col-4">
<h1>5</h1>
categories
 </div>
 <div class="col-4">
<h1>5</h1>
categories
 </div>
 <div class="col-4">
<h1>5</h1>
categories
 </div>
 <div class="col-4">
<h1>5</h1>
categories
 </div>
 
 <div class="clearfix"></div>
</div>
</div>
<!------------main content section---------->

<!------------footer section ---------->
<?php include('partial/footer.php')?>