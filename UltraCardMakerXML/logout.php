<?php
session_start();

//redirect nakon logout
if(isset($_POST['logout_no'])){
    header("Location: index.php");
}

if(isset($_POST['logout_yes'])){
    session_unset();
    header("Location: index.php");
}



?>


<!DOCTYPE html>
<html lang="en">

<?php include('header.php'); ?>

<div class="text-center  m-5 p-5">
    <h1>Are you sure you want to Logout?</h1>
    <form action="logout.php" method="post">
        <div class="m-1">
            <input type="submit" name="logout_no" value="NO" class="btn btn-danger">
        </div>
        <div class="m-1">
            <input type="submit" name="logout_yes" value="YES" class="btn btn-success">
        </div>
        

    </form>
</div>

<?php include('footer.php'); ?>
    
</body>
</html>