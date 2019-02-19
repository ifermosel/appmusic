<?php
	include_once('../controllers/controller.php');
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Music Portal</title>
		<link rel="stylesheet" href="styles/master.css">
	</head>
	<style>	
		.login-box {
			width: 600px;
			height: 200px;
			background: #000;
			color: #fff;
			border-radius: 30px 30px 30px 30px;
			top: 30%;
			left: 30%;
			position: absolute;
			box-sizing: border-box;
			padding: 70px 30px;	
			float: left;
		}

		.login-box label {
			margin: 0;
			margin-top: -30px;
			padding: 0 0;
			font-weight: bold;
			display: block;
		}

		.login-box select {
			width: 100%;
			margin-bottom: 20px;
		}

		.login-box select {
			border: none;
			border-bottom: 1px solid #fff;
			background: transparent;
			outline: none;
			height: 40px;
			color: #fff;
			font-size: 16px;	
		}

		.login-box input[type="submit"] {
			border: none;
			outline: none;
			height: 40px;
			background: #b80f22;
			color: #fff;
			font-size: 18px;
			border-radius: 20px;
		}
		
	</style>
	
	<body>
	<div class="login-box">
			<center>
			<br/>
			<form id="form" action="../controllers/controller.php" method="POST">
				<label for="track">Cancion: </label>
				<select name="pedido">
					<?php options($db); ?>
				</select>
				
				<input type="submit" name="pedir" value="Agregar a carrito">
				<input type="submit" name="limpiar" value="Limpiar carrito">
				<input type="submit" name="pagar" value="Finalizar compra"><br/><br/>
			</form>
			</center>
			<br/><br/>
		</div>		
	</body>
</html>