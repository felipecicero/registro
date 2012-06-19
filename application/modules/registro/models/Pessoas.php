<?php

class Pessoas extends Zend_Db_Table_Abstract
{

	protected $_name = 'car_pessoas';
	
	public function findByDocumento($numdoc){
    	
		$select = $this->select();
    	
    	$select->setIntegrityCheck(false);
    	
    	$select->from(array('pes' => 'car_pessoas'), array('idPessoa',  'nome', 'numeroidentificacao', 'idEndereco', 'observacoes'));

    	$select->joinInner(array('end' => 'car_enderecos'), 'pes.idEndereco = end.idEndereco', array('endereco' => 'rua', 'numero', 'complemento', 'cep', 'bairro'));
    	    	
    	$select->joinInner(array('cid' => 'car_cidades'), 'end.idCidade = cid.idCidade', array('cidade' => 'idCidade' ));
    	
    	$select->joinInner(array('est' => 'cap_estados'), 'est.idEstado = cid.idEstado', array('estado' => 'idEstado' ));
    	
    	$select->where("numeroidentificacao = '" . $numdoc . "'");
    	
		$sql = (string) $select;    
    	//print_r($sql);exit;    				   
    				   
    	return ($this->fetchAll($select));
    		
    }
}

