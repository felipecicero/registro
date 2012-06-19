<?php

class Situacoes  extends Zend_Db_Table_Abstract{
	
	protected $_name = 'car_situacoes';

	public function findForSelect()
    {
    	$select = $this->select();
    	$select->order('codigo');
    	return $this->fetchAll($select);
    }

}

