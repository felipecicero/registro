<?php

class Protocolo extends Zend_Db_Table_Abstract{

	protected $_name = 'car_protocolo';
	
	public function findForSelect()
    {
    	$select = $this->select()
    				   ->setIntegrityCheck(false) 
              		   ->where("situacao = ?", 1)
    				   ->order('protocolo');
    	return $this->fetchAll($select);
    }
    
	public function getAll()
    {
    	$select = $this->select();
    	return $this->fetchAll($select);
    }
}

