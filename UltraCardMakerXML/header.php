<?php


function display_username(){
	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];
		return $username;
	}
	return '"New Guest Duelist"';
}



?>


<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ultra Card Maker</title>

	<link rel="stylesheet" type="text/css" href="style.css">
	<!--Bootstrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-color: #00507D;">
	<header class="nav bg-dark text-primary justify-content-end">
		<div>
			<a href="index.php"><img src="" alt=""></a>
		</div>
		
		<nav class="navbar ">
			<a class="nav-link text-danger disabled" aria-disabled="true" href="#">Welcome <?php echo display_username()?></a>
			<a class="nav-link active" aria-current="page" href="index.php">Home</a>
			<a class="nav-link" href="cardBuilder.php">Create</a>
			<?php if(empty($_SESSION['username'])): ?>
			<a class="nav-link" href="login.php">Login</a>
			<?php else: ?>
			<a class="nav-link" href="logout.php">Logout</a>
			<?php endif ?>
			<a class="nav-link text-warning disabled" aria-disabled="true" href="#">Made by Dario Drame</a>
		</nav>
	</header>