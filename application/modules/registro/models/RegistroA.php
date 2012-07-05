<?php

class RegistroA extends Zend_Db_Table_Abstract{

	protected $_name = 'car_registroa';
	
	public function findForSelect()
    {
    	$select = $this->select()
    				   ->setIntegrityCheck(false);
    	return $this->fetchAll($select);
    }
	
}