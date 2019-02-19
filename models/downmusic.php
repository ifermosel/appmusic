<?php
	include_once("../db/config.php");
	$pedido = array();
	
	//Funcion para sacar las canciones como opciones en el menu
	function options($db) {
		include_once("../db/config.php");
		$sql = "SELECT TrackId, Name FROM Track LIMIT 10";
		$query = mysqli_query($db, $sql);
		echo "<option value=''>Seleccione:</option>";
		while ($row = mysqli_fetch_assoc($query)) {
			echo '<option value='.$row['TrackId'].'>'.$row['Name'].'</option>';
		}
	}
	
	//Funcion que agrega una cancion a la cookie
	function agregarCarrito($track) {
		global $pedido;

		if (!isset($_COOKIE[$_SESSION['id_user']])) {
			setcookie($_SESSION['id_user'], serialize($pedido), time()+3600);
		}else {
			$pedido = unserialize($_COOKIE[$_SESSION['id_user']]);
		}
		
		if (!cancionesRep($track)) {
			array_push($pedido, $track);
			setcookie($_SESSION['id_user'], serialize($pedido));
		}
	}
	
	//Funcion que devuelve un booleano indicando si se repite alguna cancion
	function cancionesRep($track) {
		global $pedido;
		$rep = false;
		foreach($pedido as $cancion) {
			if ($cancion == $track) {
				$rep = true;
			}
		}
		return $rep;
	}
	
	//Funcion que visualiza las canciones de la cookie
	function imprimirCarrito($db) {
		global $pedido;

		echo "<table border='1' padding='10' style='margin: 0 auto; background-color: black; color: white; margin-top: 20%;'>";
		echo "<tr><th>Cancion</th><th>Album</th><th>Precio</th></tr>";
			foreach($pedido as $cancion) {
				$sql = "SELECT Track.Name, Album.Title, Track.UnitPrice FROM Track, Album WHERE Track.AlbumId = Album.AlbumId AND Track.TrackId = '$cancion'";
				$query = mysqli_query($db, $sql);
				while($row = mysqli_fetch_assoc($query)) {
					
					echo "<tr><td>".$row['Name']."</td><td>".$row['Title']."</td><td>".$row['UnitPrice']."</td></tr>";
				}
			}
		echo "</table>";
	}
	
	//Funcion para borrar la cookie
	function limpiarCarrito() {
		global $pedido;
		setcookie($_SESSION['id_user'], "", time()-9999);
	}
	
	//Funcion para sacar el ultimo id de la tabla InvoiceLine
	function idMaxInvoiceLine($db) {
		$sqlMax = "SELECT MAX(InvoiceLineId) FROM InvoiceLine";
		$queryMax = mysqli_query($db, $sqlMax);
		$resultMax = mysqli_fetch_assoc($queryMax);
		$idInvoiceLine = $resultMax['MAX(InvoiceLineId)'];
		
		return $idInvoiceLine+1;
	}
	
	//Funcion para sacar el ultimo id de la tabla Invoice
	function idMaxInvoice($db) {
		$sqlMax = "SELECT MAX(InvoiceId) FROM Invoice";
		$queryMax = mysqli_query($db, $sqlMax);
		$resultMax = mysqli_fetch_assoc($queryMax);
		$idInvoice = $resultMax['MAX(InvoiceId)'];
		
		return $idInvoice+1;
	}
	
	//Funcion para sacar la suma de los precios de cada cacncion pedida
	function precioTotal($db) {
		global $pedido;
		$TotalPrice = 0;
		
		foreach ($pedido as $track) {
			$sql = "SELECT UnitPrice FROM Track WHERE TrackId = '$track'";
			$query = mysqli_query($db, $sql);
			$price = mysqli_fetch_assoc($query);
			$price = $price['UnitPrice'];
			$idInvoiceLine = idMaxInvoiceLine($db);
			$TotalPrice += $price;
		}
			return $TotalPrice;
	}
	
	//Funcion que realiza la compra insertando los pedidos en las tablas
	function finalizarCompra($db) {
		// include_once("../db/config.php");
		global $pedido;
		// $db = mysqli_connect('localhost','root','rootroot','musica');
		$pedido = unserialize($_COOKIE[$_SESSION['id_user']]);

		$id = $_SESSION['id_user'];
		$idInvoice = idMaxInvoice($db);
		$TotalPrice = precioTotal($db);
		
		$sql = "INSERT INTO Invoice (InvoiceId, CustomerId, InvoiceDate, BillingAddress, BillingCity, BillingState, BillingCountry, BillingPostalCode, Total) VALUES(".$idInvoice.", ".$id.", CURDATE(), 'null', 'null', 'null', 'null', 'null', ".$TotalPrice.")";
		if (mysqli_query($db, $sql)) {
			// echo "Se ha insertado correctamente.<br/>";
		}else {
			trigger_error("Error al insertar el pedido.<br/>");
			die();
		}
		
		foreach ($pedido as $track) {
			$sql = "SELECT UnitPrice FROM Track WHERE TrackId = '$track'";
			$query = mysqli_query($db, $sql);
			$price = mysqli_fetch_assoc($query);
			$price = $price['UnitPrice'];
			$idInvoiceLine = idMaxInvoiceLine($db);
			
			$sql = "INSERT INTO InvoiceLine (InvoiceLineId, InvoiceId, TrackId, UnitPrice, Quantity) VALUES(".$idInvoiceLine.", ".$idInvoice.", ".$track.", ".$price.", 1);";
			if (mysqli_query($db, $sql)) {
				// echo "Se ha insertado correctamente.<br/>";
			}else {
				trigger_error("Error al insertar los productos en el pedido.<br/>");
				die();
			}
		}
	}
	
	
	//Funcion que imprime los pedidos de hoy
	function FacturaHoy ($db) {
		$id = $_SESSION['id_user'];
		$sql = "SELECT InvoiceId, InvoiceDate, Total FROM Invoice WHERE CustomerId = '$id' AND InvoiceDate = CURDATE()";
		$query = mysqli_query($db, $sql);
		
		echo '<div style="border: 3px solid grey; border-radius: 30px 30px 30px 30px;margin-top: 250px;">';
		echo '<center><h3 style="color: black;">Lo que acabas de comprar</h3></center>';
		echo '<br/>';
		while($row = mysqli_fetch_assoc($query)) {
			echo "<table border='1' padding='10' style='margin: 0 auto; background-color: black; color: white;'>";
			echo "<tr><th>ID de pedido</th><th>Fecha de pedido</th><th>Total</th></tr>";
			echo "<tr><td>".$row['InvoiceId']."</td><td>".$row['InvoiceDate']."</td><td>".$row['Total']."</td></tr>";
			echo "</table>";
			$result = $row['InvoiceId'];
			$sql2 = "SELECT InvoiceLine.InvoiceId, Track.Name, InvoiceLine.UnitPrice, InvoiceLine.Quantity FROM Invoice, InvoiceLine, Track WHERE Invoice.InvoiceId = InvoiceLine.InvoiceId AND InvoiceLine.TrackId = Track.TrackId AND Invoice.CustomerId = '$id' AND '$result' = InvoiceLine.InvoiceId";
			$query2 = mysqli_query($db, $sql2);
			
			echo "<table border='1' padding='10' style='margin: 0 auto; background-color: black; color: white;'>";
			echo "<tr><th>ID de pedido</th><th>Nombre de cancion</th><th>Precio por cancion</th><th>Cantidad pedida</th></tr>";
			while($row2 = mysqli_fetch_assoc($query2)) {
				echo "<tr><td>".$row2['InvoiceId']."</td><td>".$row2['Name']."</td><td>".$row2['UnitPrice']."</td><td>".$row2['Quantity']."</td></tr>";
			}
			echo "</table>";
			echo "<br/><br/>";
		}
		echo "</div>";
	}
?>