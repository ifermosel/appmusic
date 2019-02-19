<!doctype html>
<?php
	// session_start();
	// if (isset($_SESSION['id_user'])) {
		// header("Location: views/welcome.php");
	// }
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Music Portal</title>
		<link rel="stylesheet" href="views/styles/master.css">
	</head>
	<body>
		<div class="login-box">
		
			<img  class="avatar" src="views/images/logo.jpg" alt="Logo musical">
			<h1>Login Music Portal</h1>
			
			<form name="myForm" action="controllers/controller.php" method="POST">
			
			<!-- Username -->
			<label for="username">Email: </label>
			<input type="text" name="email" placeholder="Enter Email">
			<!-- Password -->
			<label for="password">Password: </label>
			<input type="password" name="pass" placeholder="Enter Password">
			
			<input type="submit" name="submit" value="Log In">
			
			</form>
		</div>
	</body>
</html>