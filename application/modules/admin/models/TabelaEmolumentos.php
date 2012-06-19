<?php

class TabelaEmolumentos extends Zend_Db_Table_Abstract{

	protected $_name = 'car_tabelaemolumentos';

	public function getEmolumento($valor)
    {
    	$select = $this->select();
    	
    	$select->where('valor_inicial <= ' . $valor);
    	
    	$select->where('valor_final >= ' . $valor);
    	
    	$data = $this->fetchAll($select);
    	
    	//$sql = (string) $select;
    	//print_r($sql);exit;
    	
    	return $data->Current();
    }
}

