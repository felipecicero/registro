<?php 	
	require('fpdf.php');
	
class PDF extends FPDF{
		/**Classe feita apenas para sobreescrever o rodapé da classe fpdf**/	
	function Header()
     {
          
     }

     function Footer()
     {		          
          $this->SetFillColor(168,168,168);
		  $this->SetTextColor(0);
		  $this->SetFont('Arial','I',8);
		  		   
          $this->SetY(-2.2);
		  $this->Cell(0, 0.1, '', 0, 0,'L', true);
          
          $this->SetY(-2.5);
		  $this->Cell(4, 1.5, 'Data: ' . date('Y-m-d h:i:s'), 0, 0,'L');
          
          $this->SetXY(16, -2.5);
		  $this->Cell(4, 1.5, 'Página nº.: ' . $this->PageNo(), 0, 0,'R');		  
     }
     
}
?>
