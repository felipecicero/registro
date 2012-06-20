<?php

class ItemPedidos extends Zend_Db_Table_Abstract{

	protected $_name = 'car_itempedidos';
	
	public function findForSelect()
    {
    	$select = $this->select()
    				   ->setIntegrityCheck(false) 
    				   ->order('itempedido');
    	return $this->fetchAll($select);
    }
    
	public function getAll()
    {
    	$select = $this->select();
    	return $this->fetchAll($select);
    }

}

