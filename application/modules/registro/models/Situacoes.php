<?php

class Situacoes  extends Zend_Db_Table_Abstract{
	
	protected $_name = 'car_situacoes';

	public function findForSelect()
    {
    	$select = $this->select();
    	$select->order('nome');
    	return $this->fetchAll($select);
    }

}

