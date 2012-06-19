<?php

class TipoEmolumento extends Zend_Db_Table_Abstract{

	protected $_name = 'car_tipoemolumentos';

	public function getEmolumento($valor)
    {
    	$select = $this->select();
    	
    	$select->where('valorinicial <= ' . $valor);
    	
    	$select->where('valorfinal >= ' . $valor);
    	
    	$data = $this->fetchAll($select);
    	
    	//$sql = (string) $select;
    	//print_r($sql);exit;
    	
    	return $data->Current();
    }
	
	public function selectTipos()
    {
		$select = $this->select();
    	
    	$select->setIntegrityCheck(false);
    	
    	$select->from(array('emo' => 'car_tipoemolumentos'), array('*'));
    	
    	$select->joinInner(array('nat' => 'car_natureza'), 'emo.idNatureza = nat.idNatureza', array('natureza' => 'nome'));
		
		//$sql = (string) $select;
		//print_r($sql);exit;
		return $this->fetchAll($select);
	}
	
	public function verificaTipoCusta($id){
		
		$select = $this->select();
    	
    	$select->setIntegrityCheck(false);
		
		$select->from(array('emo' => 'car_tipoemolumentos'), array('tipo_custa'));
		
		$select->where('idEmolumentos = ?', $id);
		
		return $this->fetchAll($select)->Current();
	}
	
	public function verificaCusta($id, $tipo){
	
		if( $tipo == 1){
		
			$select = $this->select();
    	
			$select->setIntegrityCheck(false);
			
			$select->from(array('emo' => 'car_valoremolumento'), array('*'));
			
			$select->where('idEmolumento = ?', $id);
			
			return $this->fetchAll($select);
			
		}
		if( $tipo == 0){
		
			$select = $this->select();
			
			$select->setIntegrityCheck(false);
				
			$select->from(array('emo' => 'car_semvaloremolumento'), array('*'));
				
			$select->where('idEmolumento = ?' . $id);
				
			return $this->fetchAll($select);
			
		}
		else return null;
	}
}

