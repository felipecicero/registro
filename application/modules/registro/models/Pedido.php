<?php

class Pedido extends Zend_Db_Table_Abstract{

	protected $_name = 'car_pedido';
	
	public function findForSelect()
    {
    	$select = $this->select()
    				   ->setIntegrityCheck(false) 
    				   ->order('pedido');
    	return $this->fetchAll($select);
    }
    
	public function getAll()
    {
    	$select = $this->select();
    	return $this->fetchAll($select);
    }

}

