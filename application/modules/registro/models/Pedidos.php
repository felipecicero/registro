<?php

class Pedidos extends Zend_Db_Table_Abstract{

	protected $_name = 'car_pedidos';
	
	public function findForSelect()
    {
    	$select = $this->select()
    				   ->setIntegrityCheck(false);
    	return $this->fetchAll($select);
    }
    
	public function getAll()
    {
    	$select = $this->select();
    	return $this->fetchAll($select);
    }
	
	public function selectPedido($idItempedido){
	
		$select = $this->select();
    	
    	$select->setIntegrityCheck(false);
		
		$select->from(array('ite' => 'car_itempedidos'), array('numeropaginas', 'numerovias', 'numeropessoas', 'idTipodocumentos', 'idEmolumentos', 'idSituacoes'));
		
		$select->joinInner(array('pro' => 'car_protocolo'), 'pro.idProtocolo = ite.idProtocolo', array('protocolo'));
		
		$select->joinInner(array('sit' => 'car_situacoes'), 'sit.idSituacoes = ite.idSituacoes', array('situacao' => 'nome'));
		
		$select->joinInner(array('ped' => 'car_pedidos'), 'ite.idPedido = ped.idPedido', array('idPedidoFK'));
    	
		$select->joinInner(array('pe' => 'car_pedido'), 'ped.idPedidoFK = pe.idPedido', array('pedido'));
		
		$select->where('ite.idItempedido = ?', $idItempedido);
		
		//$sql = (string) $select;    
    	//print_r($sql);exit;
		
    	return $this->fetchAll($select)->Current();
	}
	
	public function selectPedidos(){
		
		$select = $this->select();
		
		$select->distinct();
    	
    	$select->setIntegrityCheck(false);
		
		$select->from(array('ped' => 'car_pedidos'), array('datapedido', 'dataprevista'));
		
		$select->joinInner(array('pe' => 'car_pedido'), 'ped.idPedidoFK = pe.idPedido', array('numero_pedido' => 'pedido'));
    	
    	$select->joinInner(array('ite' => 'car_itempedidos'), 'ped.idPedido = ite.idPedido', array('idItempedido'));
    	
		$select->joinInner(array('pro' => 'car_protocolo'), 'pro.idProtocolo = ite.idProtocolo', array('protocolo'));
		
		$select->joinInner(array('sit' => 'car_situacoes'), 'sit.idSituacoes = ite.idSituacoes', array('situacao' => 'nome'));
    	
		$select->joinInner(array('his' => 'car_historico'), 'ped.idPedido = his.idPedido', array('usuario'));
		
		$select->joinInner(array('usu' => 'car_usuarios'), 'usu.idUsuario = his.usuario', array('nome'));
		
		$select->where('ite.idSituacoes <> ?', 2);
		
		//$sql = (string) $select;    
    	//print_r($sql);exit;
		
		
		return $this->fetchAll($select);
		
	}
}

