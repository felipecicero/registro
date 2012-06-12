<?php

class Selo extends Zend_Db_Table_Abstract
{

	protected $_name = 'car_selos';

	public function getSelo($flag=''){
		$select = $this->select();
    	
    	$select->setIntegrityCheck(false);
    	
    	if($flag){
    		$select->where('quantidade > 0');
    	}
       	
    	return $this->fetchAll($select); 
	}
}
