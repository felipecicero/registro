<?php 
require('fpdf/PDF.php');

class Begin_Selos{
	
	public function relatorioSelos($data_selos, $idSituacao=''){
		
		$model_cartorio = new Cartorio();
		$data_cartorio = $model_cartorio->getCartorio();
		
		$pdf= new PDF("P","cm","A4");
	
		$motivo = $this->motivo($idSituacao);
		
		$pdf->AddPage();	
		
		$pdf->SetFont('arial', 'B', 10);
		$pdf->Cell(18.6, 2.7, "", 0, 0, 'C');
		$pdf->SetY(1);
		$pdf->Cell(18.6, 1, "TABELIONATO DE PROTESTO DE TÍTULOS DE " . $this->upper($data_cartorio->cidade),0,1,'C');		
		$pdf->SetY(1.8);
		$pdf->Cell(18.6, 1, 'RELATÓRIO DE SELOS UTILIZADOS ' . $motivo, 0, 1, 'C');
		
		$altura = 0.5;
		$pdf->SetFont('arial', '', 10);		
		$pdf->Cell(18.6, $altura,'', 1, 1, 'L');
		$pdf->SetY(2.85);
		$pdf->Cell(3, $altura,'PROTOCOLO', 0, 0, 'L');
		$pdf->Cell(10, $altura,'TIPO DO SELO', 0, 0, 'L');
		$pdf->Cell(5.6, $altura,'SELO', 0, 0, 'L');
		
		$pdf->Ln($altura);
			
		$pdf->SetFillColor(224,235,255);
	    $pdf->SetTextColor(0);
	    $pdf->SetFont('');
		    
		$fill = false;
		foreach($data_selos as $selo){
			$pdf->Cell(3, $altura, $selo->protocolo, 0, 0, 'L', $fill);
			$pdf->Cell(10, $altura, 'Padrão', 0, 0, 'L', $fill);
			$pdf->Cell(5.6, $altura, $selo->selo, 0, 0, 'L', $fill);
							
			$pdf->Ln($altura);
			$fill = !$fill;
		}
		
		$pdf->Output("Relatório de Utilização dos Selos". ".pdf", "I");
		exit;
	}

	
	
	public function motivo($idSituacao){
		
		if($idSituacao == 0 || $idSituacao == ''){
			return '';
		}
		if($idSituacao == 1){
			return 'PARA PAGAMENTO';
		}
		if($idSituacao == 2){
			return 'PARA PROTESTO';
		}
		if($idSituacao == 3){
			return 'PARA CANCELAMENTO';
		}
	}
	
	
	
	
	/**Converter um valor monetario 0.000,00*/	
	public function converte($dado){			
		if ($dado != ""){	
			return number_format($dado, 2, ",", ".");	
		} 
		else {	
			return "0,00";	
		}	
	}
     
	function getDataTimestamp($date){
		$date = substr($date, 0, 10);
		
		$date =implode("/", array_reverse(explode("-", $date )));
		
		return $date;
	}

	function ajustaCEP($data){
		$dados = str_split($data);
		$aux = '';
				
		for($i = 0; $i < count($dados); $i++){
			
			if($i==2){
				$aux = $aux . ".";
			}
			if($i==5){
				$aux = $aux . "-";
			}

			$aux = $aux . $dados[$i];
		}
		
		return $aux;
	}
	
	function ajustaCPF_CNPJ($data, $tipo=1){
		$dados = str_split($data);
		$aux = '';
				
		if($tipo == 1){//CNPJ
			for($i = 0; $i < count($dados); $i++){
				
				if($i==2 || $i==5  ){
					$aux = $aux . ".";
				}
				if($i==8){
					$aux = $aux . "/";
				}
				if($i==12){
					$aux = $aux . "-";
				}
	
				$aux = $aux . $dados[$i];
			}
		}
		
		if($tipo == 2){//CPF
			for($i = 0; $i < count($dados); $i++){
				
				if($i==3 || $i==6  ){
					$aux = $aux . ".";
				}				
				if($i==9){
					$aux = $aux . "-";
				}
	
				$aux = $aux . $dados[$i];
			}
		}
		
		return $aux;
	}

	function ajustaTelefone($data){
		$dados = str_split($data);
		$aux = '';
				
		for($i = 0; $i < count($dados); $i++){
			
			if($i == 0){
				$aux .= "(";
			}
			
			if($i==2){
				$aux = $aux . ") ";
			}
			if($i==6){
				$aux = $aux . "-";
			}
			
			$aux = $aux . $dados[$i];
		}
		
		return $aux;
	}
	
	function converteData($valor){

		$dados = str_split($valor);
		$aux = '';
				
		for($i = 0; $i < count($dados); $i++){
			
			if($i==2 || $i==4){
				$aux = $aux . "/" . $dados[$i];
			}else
			$aux = $aux . $dados[$i];
		}
		
		return $aux;
     }
     
     
	function extenso($valor=0, $maiusculas=false) {
		//print_r($valor);exit;
		$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
		$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
	
		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
	
		$z=0;
		$rt = '';
	
		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
				$inteiro[$i] = "0".$inteiro[$i];
	
	 	$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++) {
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
	
			$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&$ru) ? " e " : "").$ru;
			$t = count($inteiro)-1-$i;
			$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
			if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}

         if(!$maiusculas){
             return($rt ? $rt : "zero");
         } else {
             return ($this->upper($rt) ? $this->upper($rt) : "ZERO");
         }

	}
	
	function upper($_Str) {
		$_Str = strtoupper(trim($_Str));
		
		$Minusculo = array
		("á","à","ã","â","ä","é","è","ê","ë","í","ì","î", "ï","ó","ò","õ","ô","ö","ú","ù","û","ü","ç");
		
		$Maiusculo = array
		("Á","À","Ã","Â","Ä","É","È","Ê","Ë","Í","Ì","Î", "Ï","Ó","Ò","Õ","Ô","Ö","Ú","Ù","Û","Ü","Ç");
		
		for ( $X = 0; $X < count($Minusculo); $X++ ) { 
			$_Str = str_replace($Minusculo[$X], $Maiusculo[$X], $_Str); }
		return $_Str;
	}

}