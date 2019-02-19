<style>
<?php include_once '../views/styles/welcome.css';?>
</style>
<?php
	// set_error_handler("errores");
	include_once ("../models/login_model.php");
	include_once("../models/histfacturas.php");
	include_once("../models/downmusic.php");
	require_once("../db/config.php");
	
	
	if (isset($_POST['submit'])) {
		if (isset($_REQUEST['email']) && isset($_REQUEST['pass'])) {
			$myemail = $_REQUEST['email'];
			$mypass = $_REQUEST['pass'];
			if (checkLoginModel($db, $myemail, $mypass)) {
				include("../views/welcome.php");
				include("../views/fondo.php");
			}else {
				trigger_error("Tu email o clave son incorrectos");
				die();
			}
		}
	}
	//Para volver el inicio
	if (isset($_POST['inicio'])) {
		session_start();
		include("../views/welcome.php");
		include("../views/fondo.php");
	}
	//Para visualizar el menu de compra
	if (isset($_POST['comprar'])) {
		session_start();
		include("../views/welcome.php");
		include("../views/welcomeCompras.php");
		
	}
	//Si puelsa en agregar a carrito
	if (isset($_POST['pedir'])) {
		session_start();
		include("../views/welcome.php");
		include("../views/welcomeCompras.php");
		if ($_POST['pedido'] != '') {
			$track = $_POST['pedido'];
			agregarCarrito($track);
			include("../views/welcomeCompras.php");
			imprimirCarrito($db);
		}
	}
	//Si pulsa en limpiar carrito
	if (isset($_POST['limpiar'])) {
		session_start();
		include("../views/welcome.php");
		include("../views/welcomeCompras.php");
		limpiarCarrito();
	}
	//Si pulsa en Finalizar compra
	if (isset($_POST['pagar'])) {
		session_start();
		include("../views/welcome.php");
		include("../views/welcomeCompras.php");
		finalizarCompra($db);
		limpiarCarrito();
		facturaHoy($db);
	}
	
	//Si pulsa en Tus pedidos
	if (isset($_POST['pedidos'])) {
		session_start();
		include("../views/welcome.php");
		historialPedidosModel($db, $_SESSION['id_user']);
	}
		
	//Si pulsa en Tus pedidos por fechas para sacar el formulario
	if (isset($_POST['pfechas'])) {
		session_start();
		include("../views/welcome.php");
		include_once("../views/welcomeFechas.php");
	}
	
	//Si pulsa en Enviar despues de introducir las fechas
	if (isset($_POST['fechas'])) {
		session_start();
		include_once("../views/welcome.php");
		include_once("../models/facturas.php");
		historialPedidosfecha($db, $_SESSION['id_user'], $_POST['fechadesde'], $_POST['fechahasta']);
		
	}
	//Para cerrar sesion
	if (isset($_POST['csesion'])) {
		session_destroy();
		header("Location: ../index.php");
	}	
	
	//Funcion de control de errores
	function errores($error_level, $error_message) {
		echo "<div style='border:3px solid red; width: 350px; padding: 10px; color: red;'>";
		echo "ERROR $error_level: $error_message";
		echo "</div>";
		die();
	} 
?>

