<?php

class ControleSelo extends Zend_Db_Table_Abstract
{

	protected $_name = 'car_controleselos';
	
	public function getSelos($idSituacao='', $data_de='', $data_ate=''){
		
		$select1 = $this->select();
    	
    	$select1->setIntegrityCheck(false);
    	
    	$select1->from(array('cos' => 'car_controleselos'), array('selo'=>'numero', 'data_utilizacao'));
    	
    	$select1->joinInner(array('pro' => 'car_protestos'), 'pro.idProtesto = cos.idProtesto', array());
    	
    	$select1->joinInner(array('td' => 'car_titulos'), 'td.idTitulo = pro.idTitulo', array());
		
    	$select1->joinInner(array('prt' => 'car_protocolos'), 'td.idProtocolo = prt.idProtocolo', array('protocolo'));
		
    	if($idSituacao){
	    	$select1->where("cos.idSituacao = ?", $idSituacao);
	    }     	
		if($data_de){
    		$select1->where("cos.data_utilizacao >= '$data_de'");
    		
			if($data_ate){
	    		$select1->where("cos.data_utilizacao <= DATE_ADD('$data_ate', INTERVAL 1 DAY)");
	    	}    	
    	}
    	
    	
		$select2 = $this->select();
    	
    	$select2->setIntegrityCheck(false);
    	
    	$select2->from(array('cos' => 'car_controleselos'), array('selo'=>'numero', 'data_utilizacao'));
    	
    	$select2->joinInner(array('pro' => 'car_protestos'), 'pro.idProtesto = cos.idProtesto', array());
    	
    	$select2->joinInner(array('td' => 'car_titulos_importados'), 'td.idTitulo = pro.idTitulo', array());
		
    	$select2->joinInner(array('prt' => 'car_protocolos'), 'td.idProtocolo = prt.idProtocolo', array('protocolo'));
		
    	if($idSituacao){
	    	$select2->where("cos.idSituacao = ?", $idSituacao);
	    }     	
		if($data_de){
    		$select2->where("cos.data_utilizacao >= '$data_de'");
    		
			if($data_ate){
				$data_ate =  date($data_ate, strtotime("+1 days"));
	    		$select2->where("cos.data_utilizacao <= DATE_ADD('$data_ate', INTERVAL 1 DAY)");
	    	}    	
    	}
    	
    	$select = $this->select()
    				   ->union(array($select1, $select2))
    				   ->order('protocolo');
    				 
    	/*$sql = (string) $select;    
    	print_r("<pre>");
    	print_r($sql);
    	print_r("</pre>");
    	exit;*/
    	
    	return $this->fetchAll($select);
		
	}

}

