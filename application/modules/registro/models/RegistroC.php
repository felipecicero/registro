<?php

class RegistroC extends Zend_Db_Table_Abstract{

	protected $_name = 'car_registroc';
	
	public function findForSelect()
    {
    	$select = $this->select()
    				   ->setIntegrityCheck(false);
    	return $this->fetchAll($select);
    }
	
}

