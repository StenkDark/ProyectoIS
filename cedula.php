<?php
	
		include ("plan.php");
		
		if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) // desde paginas.php
			$id = $_GET['id'];
		else { // ID inválido, salir del script
			echo '<p class="error">Esta página se intentó acceder por error</p>';
			exit();
		}

		// Conectar a la base de datos
		require ("../mysqli_connect_is.php");
		

		// Estructurar el Procedimiento Almacenado y Ejecutarlo
		$query = "call r_pdf($id)";
		$resultado = mysqli_query($conexion, $query);
	
		// Utilizamos clase PDF
		$pdf = new PDF('L', 'mm', array(210,150));
		$pdf->AliasNbPages(); // num de páginas
		$pdf->AddPage();	//agregamos una nueva pag
			

		while ($row = mysqli_fetch_assoc($resultado)) {
			
			// Solicitud de Registro
			// Encabezados
			$pdf->SetFont('Arial','B',15);		// font-tipo-sz
			$pdf->Ln(4);	
			$pdf->Cell(120,10,utf8_decode($row['titulo']),0,1,'C'); // sz-h-txt-contorno-br-posicion título
			$pdf->SetFont('Arial','',10);		// font-tipo-sz
			$pdf->Cell(20);
			$pdf->MultiCell(150,5,utf8_decode($row['informacion']),0,'J',0); // información
		}
		$pdf->Output('F','files/anuncio_'.$id);
?>
