<?php

class Abrangencias extends Zend_Db_Table_Abstract
{
	protected $_name = 'car_abrangencia';

	public function findCeps()
    {
    	$select = $this->select();   	
    	return $this->fetchAll($select);
    }
    
	public function getAbrangencias()
    {
    	$select = $this->select(); 

    	$select->setIntegrityCheck(false);
    	
    	$select->from(array('abr' => 'car_abrangencia'), array('idFaixacep','inicio', 'limite'));
    	
    	$select->joinInner(array('cid' => 'car_cidades'), 'cid.idCidade = abr.idCidade', array('idCidade', 'cidade' => 'nome' ));
    	
    	
    	return $this->fetchAll($select);
    }
}

