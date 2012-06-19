<?php

class Emolumentofixo extends Zend_Db_Table_Abstract{

	protected $_name = 'car_emolumentofixo';

	public function verificaCusta($id)
    {
    	$select = $this->select();
    	
    	$select->setIntegrityCheck(false);
    	
    	$select->from(array('emo' => 'car_emolumentofixo'), array('*'));
    	
    	$select->where('emo.idTipoEmolumento = ?', $id);
		
		return $this->fetchAll($select)->Current();
    }
	
	public function getCusta($id)
    {
    	$select = $this->select();
    	
    	$select->setIntegrityCheck(false);
    	
    	$select->from(array('emo' => 'car_emolumentofixo'), array('*'));
		
		$select->where("emo.idEmolumentoFixo = ?", $id);
		
		$select->joinInner(array('tip' => 'car_tipoemolumentos'), 'tip.idEmolumentos = emo.idTipoEmolumento', array('nome_emolumento' => 'emolumento'));
		
		$select->joinInner(array('vig' => 'car_vigencias'), 'vig.idVigencia = tip.idVigencia', array('vigencia'));
		
		$select->joinInner(array('nat' => 'car_natureza'), 'nat.idNatureza = tip.idNatureza', array('natureza' => 'nome'));
    	
		//$sql = (string) $select;
		//print_r($sql);exit;
		
		return $this->fetchAll($select)->Current();
    }
	
	
}

