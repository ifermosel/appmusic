<?php
	function historialPedidosModel($db, $id) {
		$sql = "SELECT InvoiceId, InvoiceDate, Total FROM Invoice WHERE CustomerId = '$id'";
		$query = mysqli_query($db, $sql);
		
		echo '<div style="border: 3px solid grey; border-radius: 30px 30px 30px 30px;">';
		echo '<center><h3 style="color: black;">Historial de tus pedidos</h3></center>';
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