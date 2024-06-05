<?php
session_start();
//kratki ispis da je login / register success i onda redirect na index nakon 2sec
?>


<!DOCTYPE html>
<html lang="en">

<?php include('header.php'); ?>

<div class="text-center  m-5 p-5">
    <h1>You have succesfully registered as "<?php echo htmlspecialchars($_SESSION['username']); ?>"!</h1>
    <p>Redirecting to Home Page in 3 seconds...</p>
    <script>
        var timer = setTimeout(function() {
            window.location='index.php'
        }, 3000);
    </script>
</div>

<?php include('footer.php'); ?>
    
</body>
</html>