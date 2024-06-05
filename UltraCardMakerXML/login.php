<?php
session_start();
//vrti login dok se user ne prijavi
if(isset($_POST['username'])){
    $username = $_POST['username'];
}
else{
    $username = "";
}
if(isset($_POST['password'])){
    $password = $_POST['password'];
}
else{
    $password = "";
}

//spaja se na bazu i provjerava user-a
include('scripts/db_connect.php');


$sql = "SELECT * FROM users WHERE username='$username'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if(mysqli_num_rows($result) > 0 && password_verify($password, $row['pass'])){
    $_SESSION['username'] = htmlspecialchars($username);
    header("Location: index.php");
}



?>




<!DOCTYPE html>
<html lang="en">

	<?php include('header.php'); ?>
	<section>
		<div class="container text-center">
            <div class="m-5">
                <h2>Login</h2>
            </div>
            <form action="login.php" method="post">
                <div class="m-3">
                    <label class="text-white-50" for="userName">Username: </label>
                    <input class="bg-dark text-white-50" type="text" name="username" id="userName" />
                </div>
                <div class="m-3">
                    <label class="text-white-50" for="passWord">Password: </label>
                    <input class="bg-dark text-white-50" type="password" name="password" id="passWord" />
                </div>
                <div class="m-3">
                    <input type="submit" value="Login" class="btn btn-primary text-white"/>
                </div>
            </form>
        </div>
        <div class="text-center container">
            <p><span>Don't have an account? </span><a href="register.php" aria-selected="true" class="text-info">Register here</a></p>
        </div>
	</section>
	
    <?php include('footer.php'); ?>

</html>