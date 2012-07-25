<?php

class Situacoes  extends Zend_Db_Table_Abstract{
	
	protected $_name = 'car_situacoes';

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
    	
    	$select->from(array('sit' => 'car_situacoes'), array('nome'));
    	
    	$select->where("sit.idSituacoes = ?", $idTipo);
		
		
		//$sql = (string) $select;
		//print_r($sql);exit;
		return $this->fetchAll($select)->Current();
	}

}

