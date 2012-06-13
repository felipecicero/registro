<?php

class Natureza extends Zend_Db_Table_Abstract{

	protected $_name = 'car_natureza';
	
	public function findForSelect()
    {
    	$select = $this->select();
    	$select->order('nome DESC');
    	return $this->fetchAll($select);
    }
	
	

}

