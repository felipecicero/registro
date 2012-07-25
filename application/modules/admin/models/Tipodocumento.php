<?php

class Tipodocumento extends Zend_Db_Table_Abstract{

	protected $_name = 'car_tipodocumentos';
	
	public function selectTipos()
    {
		$select = $this->select();
    	
    	$select->setIntegrityCheck(false);
    	
    	$select->from(array('tip' => 'car_tipodocumentos'), array('*'));
    	
    	$select->joinInner(array('nat' => 'car_natureza'), 'tip.idNatureza = nat.idNatureza', array('natu' => 'nome'));
		
		//$sql = (string) $select;
		//print_r($sql);exit;
		return $this->fetchAll($select);
	}
	
	public function getLastVigencia()
    {
	
	}
	
	public function findForSelect()
    {
    	$select = $this->select();
    	$select->order('nome');
    	return $this->fetchAll($select);
    }
	
	public function selectTipo($idTipo)
    {
		
		$select = $this->select();
    	
    	$select->setIntegrityCheck(false);
    	
    	$select->from(array('tip' => 'car_tipodocumentos'), array('nome'));
    	
    	$select->where("tip.idTipodocumentos = ?", $idTipo);
		
		//$sql = (string) $select;
		//print_r($sql);exit;
		return $this->fetchAll($select)->Current();
	}
}

