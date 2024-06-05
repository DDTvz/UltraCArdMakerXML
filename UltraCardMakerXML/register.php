<?php
session_start();
// za formu, napraviti grid i onda unutar grida pozicionirati elemente npr. label justify-end / input center / error justify-start

$username = $email = $password = $confirm_password = "";
//definira errore koji će se prikazivati ukoliko user nešto krivo upiše
//razlog zašto div u kojem se ispisuje ima visinu 0px je zato što se prazan string ispisuje koji zapravo nema visine
$errors = ['username' => "", 'email' => "", 'password' => "", 'confirm_password' => ""];
$error_user = "";

//provjera upisa i validacija forme, definiranje error poruka

//spajanje na bazu i provjera postoji li takav user kreiranje novog usera
//redirect na succes page

include('scripts/db_connect.php');


if(isset($_POST['submit'])){
    //provjera upisa i validacija forme, definiranje error poruka
    if(empty($_POST['email'])){
        $errors['email'] = 'An email is required!<br />';
    }else{
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Mail is not valid!";
        }
    }
    
    if(empty($_POST['username'])){
        $errors['username'] = 'A username is required!<br />';
    }else{
        $username = $_POST['username'];
        if(!preg_match('/^[a-zA-Z0-9]+$/',$username)){
            $errors['username'] = "Username must consist only of letters, numbers and underscores(_)!";
        }
    }

    if(empty($_POST['password'])){
        $errors['password'] = 'A password is required!<br />';
    }else{
        $password = $_POST['password'];
        if(!preg_match('/^[a-zA-Z0-9]+$/',$password)){
            $errors['password'] = "Password can consist of anything except: ";
        }
    }

    if(empty($_POST['confirm_password'])){
        $errors['confirm_password'] = 'You must confirm your password!<br />';
    }else{
        $confirm_password = $_POST['confirm_password'];
        if($confirm_password != $password){
            $errors['confirm_password'] = "Password and confirm password must match!";
        }
    }
 

    //gleda ima li errora, odnosno dal pokazivači unutar array errors pokazuju na prazne vrijednosti --> "" = prazan string = false
    //funkcija array_filter ako je sve false izbacuje false
    if(!array_filter($errors)){
        //echo "errors in form...";

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];
        $hashed_password = password_hash($password, CRYPT_BLOWFISH);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

        //check if username or email already exsist
        $exists_username_sql = "SELECT * FROM users WHERE username='$username'";
        $exists_email_sql = "SELECT * FROM users WHERE email='$email'";
        $result_username = mysqli_query($conn, $exists_username_sql);
        $result_email = mysqli_query($conn, $exists_email_sql);

        if(mysqli_num_rows($result_username)>0){
            $error_user = "User with this Username already exists!";
        }
        elseif(mysqli_num_rows($result_email)>0){
            $error_user = "User with this Email already exists!";
        }
        else{
        $sql = "INSERT INTO users(username, email, pass) VALUES ('$username', '$email','$hashed_password')";

        //save to database and check
        if(mysqli_query($conn, $sql)){
            $_SESSION['username'] = $username;

       }else{

         echo 'query error: ' . mysqli_error($conn);
        }
        }

        
    }else{
        //header("Location: index.php");
    }
}
?>


<!DOCTYPE html>
<html lang="en">

	<?php include('header.php'); ?>
	<section>
		<div class="text-center container">
            <div class="m-5">
                <h2>Register</h2>
            </div>
            <form action="register.php" method="post">
                <div class="m-3">
                    <label for="userName" class="text-white-50">Username: </label>
                    <input class="bg-dark text-white-50" type="text" name="username" id="userName" value="<?php echo htmlspecialchars($username)?>"/>
                    <div class="text-danger"><?php echo $errors['username'];?></div>
                </div>

                <div class="m-3">
                    <label class="text-white-50" for="email">E-mail: </label>
                    <input class="bg-dark text-white-50" type="text" name="email" id="email" value="<?php echo htmlspecialchars($email)?>"/>
                    <div class="text-danger"><?php echo $errors['email'];?></div>
                </div>

                <div class="m-3">
                    <label class="text-white-50" for="passWord">Password: </label>
                    <input class="bg-dark text-white-50" type="password" name="password" id="passWord" value="<?php echo htmlspecialchars($password)?>"/>
                    <div class="text-danger"><?php echo $errors['password'];?></div>
                </div>

                <div class="m-3">
                    <label class="text-white-50" for="confirmPassword">Confrim Password: </label>
                    <input class="bg-dark text-white-50" type="password" name="confirm_password" id="confirmPassword" value="<?php echo htmlspecialchars($confirm_password)?>"/>
                    <div class="text-danger"><?php echo $errors['confirm_password'];?></div>
                </div>

                <div class="m-3">
                    <input type="submit" name="submit" value="Register" class="btn btn-primary text-white" />
                </div>
            </form>
        </div>
        <div class="m-5 text-danger text-center">
            <p><?php echo $error_user; ?></p>
        </div>
        <div class="text-center container">
            <p><span>Already have an account? </span><a href="login.php" aria-selected="true" class="text-info">Login Here</a></p>
        </div>
	</section>
	
    <?php include('footer.php'); ?>

</html>