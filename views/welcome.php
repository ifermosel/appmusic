<!doctype html>
<?php
	include_once("../controllers/controller.php");
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Music Portal</title>
		<link rel="stylesheet" href="styles/welcome.css">
	</head>
	<body>
		<header>
			<!-- <img  class="avatar" src="images/logo.jpg" alt="Logo musical"> -->
			<h1>Bienvenid@, <?php echo $_SESSION['name_user'];?></h1>
		
			<nav>
				<form action="" method="POST">
					<ul>
						<li><input type="submit" name="inicio" value="Inicio"></li>
						<li><input type="submit" name="comprar" value="Hacer pedido"></li>
						<li><input type="submit" name="pedidos" value="Tus pedidos"></li>
						<li><input type="submit" name="pfechas" value="Tus pedidos por fechas"></li>
						<li><input type="submit" name="csesion" value="Cerrar sesion"></li>
					</ul>
				<form>
			</nav>
			
		</header>
	</body>
</html>