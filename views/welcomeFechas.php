<html>
	<head>
		<meta charset="utf-8">
		<title>Music Portal</title>
		<link rel="stylesheet" href="styles/master.css">
	</head>
	<style>	
		.login-box {
			width: 320px;
			height: 380px;
			background: #000;
			color: #fff;
			border-radius: 30px 30px 30px 30px;
			top: 60%;
			left: 50%;
			position: absolute;
			transform: translate(-50%, -50%);
			box-sizing: border-box;
			padding: 70px 30px;	
		}

		.login-box label {
			margin: 0;
			padding: 0 0;
			font-weight: bold;
			display: block;
		}

		.login-box input {
			width: 100%;
			margin-bottom: 20px;
		}

		.login-box input[type="text"] {
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
				<label for="fechad">Fecha desde: </label>
				<input type="text" name="fechadesde" placeholder="aaaa-mm-dd"><br/><br/>
				<label for="fechah">Fecha hasta: </label>
				<input type="text" name="fechahasta" placeholder="aaaa-mm-dd"><br/><br/>
				
				<input type="submit" name="fechas" value="Enviar"><br/><br/>
			<form>
			</center>
			<br/><br/>
		</div>		
	</body>
</html>