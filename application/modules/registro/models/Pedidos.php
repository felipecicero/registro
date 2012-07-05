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
		
		$select->from(array('ite' => 'car_itempedidos'), array('idItempedido', 'idPedido', 'idProtocolo', 'numeropaginas', 'numerovias', 'numeropessoas', 'idTipodocumentos', 'idEmolumentos', 'idSituacoes'));
		
		$select->where('ite.idItempedido = ?', $idItempedido);
		
		$select->joinInner(array('pro' => 'car_protocolo'), 'pro.idProtocolo = ite.idProtocolo', array('protocolo'));
		
		$select->joinInner(array('sit' => 'car_situacoes'), 'sit.idSituacoes = ite.idSituacoes', array('situacao' => 'nome'));
		
		$select->joinInner(array('ped' => 'car_pedidos'), 'ite.idPedido = ped.idPedido', array('idPedidoFK'));
    	
		$select->joinInner(array('pe' => 'car_pedido'), 'ped.idPedidoFK = pe.idPedido', array('pedido'));
		
		$select->joinInner(array('pesO' => 'car_pessoas'), 'ite.idPessoasnotificado = pesO.idPessoas', array('tipo_identificacao_notificado' => 'tipo_identificacao', 'numeroidentificacao_notificado' => 'numeroidentificacao', 'nome_notificado' => 'nome', 'observacoes_notificado' => 'observacoes', 'telefone_notificado' => 'telefone'));
		
		$select->joinInner(array('endO' => 'car_enderecos'), 'endO.idEndereco = pesO.idEndereco', array('rua_notificado' => 'rua', 'numero_notificado' => 'numero', 'complemento_notificado' => 'complemento', 'cep_notificado' => 'cep', 'bairro_notificado' => 'bairro'));
		
		$select->joinInner(array('cidO' => 'car_cidades'), 'endO.idCidade = cidO.idCidade', array('cidade_notificado' => 'nome'));
		
		$select->joinInner(array('estO' => 'car_estados'), 'cidO.idEstado = estO.idEstado', array('estado_notificado' => 'nome', 'sigla_notificado' => 'sigla'));
		
		$select->joinInner(array('pesE' => 'car_pessoas'), 'ite.idPessoasnotificante = pesE.idPessoas', array('tipo_identificacao_notificante' => 'tipo_identificacao', 'numeroidentificacao_notificante' => 'numeroidentificacao', 'nome_notificante' => 'nome', 'observacoes_notificante' => 'observacoes', 'telefone_notificante' => 'telefone'));
		
		$select->joinInner(array('endE' => 'car_enderecos'), 'endE.idEndereco = pesE.idEndereco', array('rua_notificante' => 'rua', 'numero_notificante' => 'numero', 'complemento_notificante' => 'complemento', 'cep_notificante' => 'cep', 'bairro_notificante' => 'bairro'));
		
		$select->joinInner(array('cidE' => 'car_cidades'), 'endE.idCidade = cidE.idCidade', array('cidade_notificante' => 'nome'));
		
		$select->joinInner(array('estE' => 'car_estados'), 'cidE.idEstado = estE.idEstado', array('estado_notificante' => 'nome', 'sigla_notificante' => 'sigla'));
		
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

