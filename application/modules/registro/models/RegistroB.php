<?php

class RegistroB extends Zend_Db_Table_Abstract{

	protected $_name = 'car_registrob';
	
	public function findForSelect()
    {
    	$select = $this->select()
    				   ->setIntegrityCheck(false);
    	return $this->fetchAll($select);
    }
	
}

