<?php

class TitulodocumentosController extends Zend_Controller_Action
{

    private $model_pedidos = null;
    private $model_pedido = null;
    private $model_protocolo = null;
    private $model_historico = null;
    private $model_itempedido = null;
    private $model_tipoemolumento = null;
    private $model_custas = null;
    private $model_tabelaemolumentos = null;
	private $model_emolumentofixo = null;

    public function init()
    {
        if ( !Zend_Auth::getInstance()->hasIdentity() ) {
	        return $this->_helper->redirector->goToRoute( array('module'=>'admin', 'controller' => 'auth'), null, true);
	    }
	    
		$params     = $this->getRequest()->getParams();			
	    $model_acl 	= new Acl();	    
	    $result = $model_acl->isAllowed($params["controller"] . "/" . $params["action"]);	    
	    if(!$result){
	    	ZendX_JQuery_FlashMessenger::addMessage("Área do sistema restrita.", 'error');
	    	$this->_redirect('/registro/index');	    	
	    }

	    $authNamespace = new Zend_Session_Namespace('before');
		$authNamespace->before = $params["controller"] . "/" . $params["action"];
		
		
		parent::init();
		
		$this->model_pedidos = new Pedidos();
		$this->model_protocolo = new Protocolo();
		$this->model_pedido = new Pedido();
		$this->model_itempedido = new ItemPedidos();
		$this->model_tipoemolumento = new TipoEmolumento();
		$this->model_custas = new Custa();
		$this->model_tabelaemolumentos = new TabelaEmolumentos();
		$this->model_emolumentofixo = new Emolumentofixo();
		
		$this->view->setEncoding('ISO-8859-1');
    }

    public function indexAction()
    {
        // action body
    }

    public function cadastrotitulodocumentoAction()
    {
        // action body
    }

    public function pedidoAction()
    {
        $form = new Registro_Form_Pedido();
		
		//if(isset($_SESSION['itempedido'])) unset($_SESSION['itempedido']);
		if ( $this->_request->isPost()){
			
			$pedido['data_pedido']		= $this->_request->getPost('data_pedido');
			$pedido['data_prevista']	= $this->_request->getPost('data_prevista');
			$pedido['data_entrega']		= $this->_request->getPost('data_entrega');
			$pedido['idSituacoes']		= $this->_request->getPost('idSituacao');
			$pedido['valor_pedido']		= $this->_request->getPost('valor_pedido');
			$pedido['valor_deposito']	= $this->_request->getPost('valor_deposito');
			$pedido['valor_receber']	= $this->_request->getPost('valor_receber');
			
			$requerente = $this->_request->getPost('Requerente');
			
			$form->data_pedido->setValue('data_pedido');
			$form->data_prevista->setValue('data_prevista');
			$form->data_entrega->setValue($pedido['data_entrega']);
			$form->idSituacao->setValue($pedido['idSituacoes']);
			$form->valor_pedido->setValue($pedido['valor_pedido']);
			$form->valor_deposito->setValue($pedido['valor_deposito']);
			$form->valor_receber->setValue($pedido['valor_receber']);
			$form->Requerente->tipo_identificacao_requerente->setValue($requerente['tipo_identificacao_requerente']);
			$form->Requerente->documento_requerente->setValue($requerente['documento_requerente']);
			$form->Requerente->nome_requerente->setValue($requerente['nome_requerente']);
			$form->Requerente->telefone_requerente->setValue($requerente['telefone_requerente']);
			$form->Requerente->cep_requerente->setValue($requerente['cep_requerente']);
			$form->Requerente->endereco_requerente->setValue($requerente['endereco_requerente']);
			$form->Requerente->complemento_requerente->setValue($requerente['complemento_requerente']);
			$form->Requerente->bairro_requerente->setValue($requerente['bairro_requerente']);
			$form->Requerente->numero_requerente->setValue($requerente['numero_requerente']);
			$form->Requerente->estado_requerente->setValue($requerente['estado_requerente']);
			
			$city = new Cidade();
			$cidade = $city->findcity($requerente['cidade_requerente']);
			
			$form->Requerente->cidade_requerente->addMultiOption($cidade->idCidade, $cidade->nome);
			$form->Requerente->cidade_requerente->setValue($requerente['cidade_requerente']);
			$form->Requerente->obs_requerente->setValue($requerente['obs_requerente']);
			
			$form->itensPedido();
			$this->view->form = $form;
			
			if ( $this->_request->getPost('adicionar') || $this->_request->getPost('submitfinal')){
								
				$itens = $this->_request->getPost('itempedido');
				
				$_SESSION['itempedido'][] = $itens;
					
			}
				
			if($this->_request->getPost('submitfinal')){
				
				$user = new Zend_Session_Namespace('user_data');
				
				$data_historico['usuario'] = $user->user->idUsuario;
				
				$data_requerente = array(
					'tipo_identificacao'	=> $requerente['tipo_identificacao_requerente'],
					'numeroidentificacao'	=> preg_replace('/[^0-9]/', '', $requerente['documento_requerente']),	
					'nome' 					=> strtoupper ($requerente['nome_requerente']),
					'telefone' 				=> preg_replace('/[^0-9]/', '', $requerente['telefone_requerente']),
					'cep' 					=> preg_replace('/[^0-9]/', '', $requerente['cep_requerente']),
					'rua' 					=> strtoupper ($requerente['endereco_requerente']),
					'complemento' 			=> strtoupper ($requerente['complemento_requerente']),
					'bairro' 				=> strtoupper ($requerente['bairro_requerente']),
					'numero' 				=> strtoupper ($requerente['numero_requerente']),
					'cidade' 				=> strtoupper ($requerente['cidade_requerente']),
					'observacoes' 			=> strtoupper ($requerente['obs_requerente'])
				);
				
				$data_pedido = array(
					'idPedidoFK'	=> $this->getUltimoPedido(),
					'datapedido' 	=> date('Y-m-d h:i:s'),
					'dataprevista' 	=> preg_replace('/[^0-9]/', '', $pedido['data_prevista']),
					'valorpedido' 	=> preg_replace('/[^0-9]/', '', $pedido['valor_pedido']),
					'valordeposito' => preg_replace('/[^0-9]/', '', $pedido['valor_deposito']),
					'valorreceber' 	=> preg_replace('/[^0-9]/', '', $pedido['valor_receber']),
					'idSituacoes'	=> preg_replace('/[^0-9]/', '', $pedido['idSituacoes']),
					'idRequerente'	=> $this->cadastrarPessoa($data_requerente)
				);
				
				$idPedido = $this->cadastrarPedido($data_pedido);
				
				$data_historico['idPedido'] = $idPedido;
				
				
				foreach($_SESSION['itempedido'] as $itens){
					
					$data_notificante = array(
						'tipo_identificacao'	=> $itens['notificante']['tipo_identificacao_notificante'],
						'numeroidentificacao'	=> preg_replace('/[^0-9]/', '', $itens['notificante']['documento_notificante']),	
						'nome' 					=> strtoupper ($itens['notificante']['nome_notificante']),
						'telefone' 				=> preg_replace('/[^0-9]/', '', $itens['notificante']['telefone_notificante']),
						'cep' 					=> preg_replace('/[^0-9]/', '', $itens['notificante']['cep_notificante']),
						'rua' 					=> strtoupper ($itens['notificante']['endereco_notificante']),
						'complemento' 			=> strtoupper ($itens['notificante']['complemento_notificante']),
						'bairro' 				=> strtoupper ($itens['notificante']['bairro_notificante']),
						'numero' 				=> strtoupper ($itens['notificante']['numero_notificante']),
						'cidade' 				=> strtoupper ($itens['notificante']['cidade_notificante']),
						'observacoes' 			=> strtoupper ($itens['notificante']['obs_notificante'])
					);
					
					$data_notificado = array(
						'tipo_identificacao'	=> $itens['notificado']['tipo_identificacao_notificado'],
						'numeroidentificacao'	=> preg_replace('/[^0-9]/', '', $itens['notificado']['documento_notificado']),	
						'nome' 					=> strtoupper ($itens['notificado']['nome_notificado']),
						'telefone' 				=> preg_replace('/[^0-9]/', '', $itens['notificado']['telefone_notificado']),
						'cep' 					=> preg_replace('/[^0-9]/', '', $itens['notificado']['cep_notificado']),
						'rua' 					=> strtoupper ($itens['notificado']['endereco_notificado']),
						'complemento' 			=> strtoupper ($itens['notificado']['complemento_notificado']),
						'bairro' 				=> strtoupper ($itens['notificado']['bairro_notificado']),
						'numero' 				=> strtoupper ($itens['notificado']['numero_notificado']),
						'cidade' 				=> strtoupper ($itens['notificado']['cidade_notificado']),
						'observacoes' 			=> strtoupper ($itens['notificado']['obs_notificado'])
					);
					
					$data_itempedido = array(
						'idPedido' 				=> $idPedido,
						'idProtocolo' 			=> $this->getUltimoProtocolo(),
						'idTipodocumentos' 		=> preg_replace('/[^0-9]/', '', $itens['tipodocumentos']),
						'idEmolumentos' 		=> preg_replace('/[^0-9]/', '', $itens['tipoemolumento']),
						'idSituacoes' 			=> preg_replace('/[^0-9]/', '', $itens['pedido_situacao']),
						'datasituacao' 			=> date('Y-m-d h:i:s'),
						'numeropaginas' 		=> preg_replace('/[^0-9]/', '', $itens['numeropaginas']),
						'numerovias' 			=> preg_replace('/[^0-9]/', '', $itens['numerovias']),
						'numeropessoas' 		=> preg_replace('/[^0-9]/', '', $itens['numeropessoas']),
						'valordocumento' 		=> preg_replace('/[^0-9]/', '', $itens['valordocumento']),
						'valorcorreio' 			=> preg_replace('/[^0-9]/', '', $itens['valor_correio']),
						'outrasdespesas' 		=> preg_replace('/[^0-9]/', '', $itens['outrasdespesas']),
						'idPessoasnotificado' 	=> $this->cadastrarPessoa($data_notificado),	
						'idPessoasnotificante' 	=> $this->cadastrarPessoa($data_notificante)	
					);
							
					$data_historico['idItempedido'] = $this->cadastrarItemPedido($data_itempedido);
					$data_historico['descricao'] =  'Item de Pedido Cadastrado.';
					
					$this->cadastrarHistoricoPedidos($data_historico);
					
					unset($data_historico['idItempedido']);
					unset($data_historico['descricao']);
				}
				unset($_SESSION['itempedido']);
				
				ZendX_JQuery_FlashMessenger::addMessage("Título cadastrado com sucesso.");
				$form = new Registro_Form_Pedido();	
			}
		}
		$form->data_pedido->setValue(date('dmY'));
		$form->data_prevista->setValue($this->addDayIntoDate(date('dmY'),4));
		$this->view->form = $form;
	}
	
    public function getpessoaAction()
    {
		$this->_helper->layout ()->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ();
		
		$doc = $_GET['doc'];

		$doc = preg_replace('/[^0-9]/', '', $doc);
	   
		$model_pessoas = new Pessoas();
		$pessoa = $model_pessoas->findByDocumento($doc);

		if(isset($pessoa->idPessoas)){
			
       		$pessoa->cep = $this->_helper->Util->ajustaCEP($pessoa->cep);      		
       		$nome = "<input type='hidden' name='idnome".$doc."' id='idnome".$doc."'  value='" . htmlentities($pessoa->nome) . "' >";
       		$telefone = "<input type='hidden' name='idtelefone".$doc."' id='idtelefone".$doc."'  value='" . htmlentities($pessoa->telefone) . "' >";
       		$cep = "<input type='hidden' name='idcep".$doc."' id='idcep".$doc."'  value='" . $pessoa->cep . "' >";
       		$endereco = "<input type='hidden' name='idendereco".$doc."' id='idendereco".$doc."'  value='" . htmlentities($pessoa->endereco) . "' >";
       		$complemento = "<input type='hidden' name='idcomplemento".$doc."' id='idcomplemento".$doc."'  value='" . htmlentities($pessoa->complemento) . "' >";
       		$bairro = "<input type='hidden' name='idbairro".$doc."' id='idbairro".$doc."'  value='" . htmlentities($pessoa->bairro) . "' >";
       		$numero = "<input type='hidden' name='idnumero".$doc."' id='idnumero".$doc."'  value='" . $pessoa->numero . "' >";
       		$uf = "<input type='hidden' name='iduf".$doc."' id='iduf".$doc."'  value='" . $pessoa->estado . "' >";
       		$cidade = "<input type='hidden' name='idcidade".$doc."' id='idcidade".$doc."'  value='" . $pessoa->cidade . "' >";
       		$obs = "<input type='hidden' name='idobs".$doc."' id='idobs".$doc."'  value='" . $pessoa->observacoes . "' >";
       		
       		echo $nome . $telefone . $cep . $endereco . $complemento . $bairro .$numero . $uf . $cidade . $obs;
		}
        	   
		exit();
    }

    public function cadastrarPessoa($data)
    {
    	$model_pessoa = new Pessoas();
		
        $select =  $model_pessoa->select() 
                   		  ->setIntegrityCheck(false) 
              			  ->where("numeroidentificacao = '" . $data['numeroidentificacao'] . "'");
        
		$pessoa = $model_pessoa->fetchAll($select);
        
        $data_endereco['cep'] = $data['cep']; unset($data['cep']);
		$data_endereco['rua'] = $data['rua']; unset($data['rua']);
		$data_endereco['complemento'] = $data['complemento']; unset($data['complemento']);
		$data_endereco['bairro'] = $data['bairro']; unset($data['bairro']);
		$data_endereco['numero'] = $data['numero']; unset($data['numero']);
		$data_endereco['idCidade'] = $data['cidade']; unset($data['cidade']);
        
		
		if(count($pessoa) > 0){
			
			$model_pessoa->update($data, "idPessoas = " . $pessoa->Current()->idPessoas);

			$this->cadastrarEndereco($data_endereco, $pessoa->Current()->idEndereco);
			
			return $pessoa->Current()->idPessoas;
		}
		else{			
			$data['idEndereco'] = $this->cadastrarEndereco($data_endereco);
			 
			$model_pessoa->insert($data);
            return $model_pessoa->getAdapter()->lastInsertId();
		
		}
    }

    public function cadastrarEndereco($data, $id = '')
    {
    	$model_endereco = new Endereco();
    	 
    	if($id){
    		$data['cep'] = preg_replace('/[^0-9]/', '', $data['cep']);
    		$model_endereco->update($data, "idEndereco = " . $id);
    	}
    	else{
			$data['cep'] = preg_replace('/[^0-9]/', '', $data['cep']);

        	$model_endereco->insert($data);
        	return $model_endereco->getAdapter()->lastInsertId();
    	}
    	return true;
    }

    public function cadastrarpedidoAction()
    {
        // action body
    }

    public function getcidadesAction()
    {
       $this->_helper->layout ()->disableLayout ();
	   $this->_helper->viewRenderer->setNoRender ();
	       	
	   $id = (int) $this->_getParam('idEstado');
	   $id = $_GET['id'];
       $model_cidade = new Cidade();
       $cidades = $model_cidade->findForSelect($id)->toArray();
   	   //print_r($cidades);exit;
       $combo = "<option value='0'>Carregando ... </option>";

       if (count($cidades) > 0) {
           
       	   $combo = array ();
           $combo .= '<option value = "">Selecione a Cidade</option>';
           foreach ( $cidades as $lista ) {           	
           			if($lista ['idCidade'] == 9899){
                  		$combo .= '<option value="' . $lista ['idCidade'] . '" selected="selected">' . $lista ['nome'] . '</option>';
           			}
                  	else{
                  		$combo .= '<option value="' . $lista ['idCidade'] . '">' . $lista ['nome'] . '</option>';           
                  	}
           }
      }
      
      echo $combo;
    }

    public function getEmolumentoAction()
    {
       $this->_helper->layout ()->disableLayout ();
	   $this->_helper->viewRenderer->setNoRender ();

	   $valor = $_GET['valor'];
	   //$valor = (int) $this->_getParam('valor');
	   $valor = str_replace('.', '', $valor);
	   $valor = str_replace(',', '.', $valor);
       $model_emolumento = new Emolumento();
       $emolumento = $model_emolumento->getEmolumento($valor);
   	   
       $html = "<input type='text' name='emolumento' id='emolumento' value='0,00' />";
       
       if(isset($emolumento->emolumento)){       		
       		$html = "<input type='text' name='emolumento' id='emolumento'  value='" . number_format($emolumento->emolumento, 2, ",", ".") . "' />";       		
       }
       
  	   echo $html;
  	   
  	   exit ();
    }

    public function getUltimoPedido()
    {
    	$model_pedido = new Pedido();

	 	$select = $model_pedido	->select()
								->setIntegrityCheck(false)
    				  			->where("situacao = ?", 1); 

    	$pedido = $model_pedido->fetchAll($select);
    	
    	if(count($pedido) == 0){
    		$model_pedido->insert(array('pedido' => 1, 'situacao' => 1));
    		return $model_pedido->getAdapter()->lastInsertId();
    	}
               
        return $pedido[count($pedido)-1]->idPedido;
    }

    public function getUltimoProtocolo()
    {
    	$model_protocolo = new Protocolo();

    	/****VERIFICAR SE O BANCO TA VAZIO***/
	 	$select = $model_protocolo->select()
    				  			  ->setIntegrityCheck(false)
    				  			  ->where("situacao = ?", 1); 

    	$protocolo = $model_protocolo->fetchAll($select);
    	
    	if(count($protocolo) == 0){
    		$model_protocolo->insert(array('protocolo' => 1, 'situacao' => 1));
    		return $model_protocolo->getAdapter()->lastInsertId();
    	}
		
        return $protocolo[count($protocolo)-1]->idProtocolo;
    }

    public function updateProtocolo($idProtocolo)
    {
    	$model_protocolo = new Protocolo();

	 	$select =  $model_protocolo->select() 
                   		  		   ->setIntegrityCheck(false) 
              			  		   ->where("idProtocolo = ?", $idProtocolo);
        $protocolo = $model_protocolo->fetchAll($select);

        $data_protocolo = array(
        						'situacao' => '2'
        				  );
        
        
		if(isset($protocolo['_data'])){			
	        $where = $model_protocolo->getAdapter()->quoteInto('idProtocolo = ?', $idProtocolo);
	        $model_protocolo->update($data_protocolo, $where);

	        $data_protocolo = array('protocolo' => ($protocolo['_data']->protocolo + 1),
	        						'situacao' => '1');

        	$model_protocolo->insert($data_protocolo);
			$model_protocolo->getAdapter()->lastInsertId();
		}
    	
    }

    public function updatePedido($idPedido)
    {
    	$model_pedido = new Pedido();

	 	$select =  $model_pedido->select() 
                   		  		->setIntegrityCheck(false) 
              			  		->where("idPedido = ?", $idPedido);
        $pedido = $model_pedido->fetchAll($select);
        
        $data_pedido = array('situacao' => '2');

		if(isset($pedido['_data'])){			
	        $where = $model_pedido->getAdapter()->quoteInto('idPedido = ?', $idPedido);
	        $model_pedido->update($data_pedido, $where);

	        $data_pedido = array('pedido' => ($pedido['_data']->pedido + 1),
								 'situacao' => '1');
			
        	$model_pedido->insert($data_pedido);
			$model_pedido->getAdapter()->lastInsertId();
		}
    	
    }

    public function cadastrarPedido($data)
    {
		$model_pedido = new Pedidos();
	
		$select =  $model_pedido->select() 
                   		  		->setIntegrityCheck(false) 
              			  		->where("idPedidoFK = ?", $data['idPedidoFK']);
        $pedido = $model_pedido->fetchAll($select);
        
		if(isset($pedido['_data'])){
			return $pedido['_data']->idPedido;
		}
		else{

			$model_pedido->insert($data);
			$idPedido = $model_pedido->getAdapter()->lastInsertId();
			
			$this->updatePedido($data['idPedidoFK']);
			 
            return $idPedido;
		}	
    }

    public function cadastrarItemPedido($data)
    {
		
		$model_itempedido = new ItemPedidos();
		
		$select =  $model_itempedido->select() 
									->setIntegrityCheck(false) 
									->where("idProtocolo = ?", $data['idProtocolo']);
        $itempedido = $model_itempedido->fetchAll($select);
        
		if(isset($itempedido['_data'])){
			return $itempedido['_data']->idItempedido;
		}
		else{

			$model_itempedido->insert($data);
			$idItempedido = $model_itempedido->getAdapter()->lastInsertId();
			
			$this->updateProtocolo($data['idProtocolo']);
			 
            return $idItempedido;
		}	
    }

    public function cadastrarHistoricoPedidos($data)
    {
    	$model_historico = new Historico();
		
		$model_historico->insert($data);
		
		return $model_historico->getAdapter()->lastInsertId();
		
    }

    public function acompanhamentoAction()
    {
		$data = $this->model_pedidos->selectPedidos();
	
		
		$this->view->pedidos = $data;
    }

    public function itenspedidoAction()
    {
        $form = new Registro_Form_Itenspedido();
		
		$pedido = $this->model_pedidos->selectPedido((int) $this->_getParam('idItempedido'));
		
		$idItempedido = $pedido['idItempedido'];
		$idProtocolo = $pedido['idProtocolo'];
		$idPedido = $pedido['idPedido'];
		
		$form->pedido->setValue($pedido->pedido);
		$form->item_pedido->setValue($pedido->protocolo);
		$form->pedido_situacao->setValue($pedido->situacao);
		$form->tipodocumentos->setValue($pedido->idTipodocumentos);
		$form->tipoemolumento->setValue($pedido->idEmolumentos);
		$form->numeropaginas->setValue($pedido->numeropaginas);
		$form->numerovias->setValue($pedido->numerovias);
		$form->numeropessoas->setValue($pedido->numeropessoas);
		
		$_SESSION['pessoascitadas']['notificado'] = array (
			'tipo_identificacao'	=> $pedido['tipo_identificacao_notificado'],
            'numeroidentificacao'	=> $pedido['numeroidentificacao_notificado'],
            'nome' 					=> $pedido['nome_notificado'],
            'observacoes' 			=> $pedido['observacoes_notificado'],
            'telefone' 				=> $pedido['telefone_notificado'],
            'rua' 					=> $pedido['rua_notificado'],
            'numero' 				=> $pedido['numero_notificado'],
            'complemento' 			=> $pedido['complemento_notificado'],
            'cep' 					=> $pedido['cep_notificado'],
            'bairro' 				=> $pedido['bairro_notificado'],
            'cidade' 				=> $pedido['cidade_notificado'],
            'estado' 				=> $pedido['estado_notificado'],
            'sigla' 				=> $pedido['sigla_notificado'],
			'notificar'				=> 'Notificar'
		);
		
		$_SESSION['pessoascitadas']['notificante'] = array (
			'tipo_identificacao'	=> $pedido['tipo_identificacao_notificante'],
            'numeroidentificacao'	=> $pedido['numeroidentificacao_notificante'],
            'nome' 					=> $pedido['nome_notificante'],
            'observacoes' 			=> $pedido['observacoes_notificante'],
            'telefone' 				=> $pedido['telefone_notificante'],
            'rua' 					=> $pedido['rua_notificante'],
            'numero' 				=> $pedido['numero_notificante'],
            'complemento' 			=> $pedido['complemento_notificante'],
            'cep' 					=> $pedido['cep_notificante'],
            'bairro' 				=> $pedido['bairro_notificante'],
            'cidade' 				=> $pedido['cidade_notificante'],
            'estado' 				=> $pedido['estado_notificante'],
            'sigla' 				=> $pedido['sigla_notificante'],
			'notificar'				=> 'Apresentante'
		);
		
			if ( $this->_request->isPost()){
			
				$this->view->form = $form;
				
				if ( $this->_request->getPost('adicionar') || $this->_request->getPost('submitfinal')){
					
					$pessoas = $this->_request->getPost('Pessoa');
					
					if(isset($pessoas['documento_citado'])){
						
						$_SESSION['pessoascitadas'][] = array(
							'tipo_identificacao'	=> $pessoas['tipo_identificacao_citado'],
							'numeroidentificacao'	=> preg_replace('/[^0-9]/', '', $pessoas['documento_citado']),
							'nome' 					=> $pessoas['nome_citado'],
							'observacoes' 			=> $pessoas['obs_citado'],
							'telefone' 				=> $pessoas['telefone_citado'],
							'rua' 					=> $pessoas['endereco_citado'],
							'numero' 				=> $pessoas['numero_citado'],
							'complemento' 			=> $pessoas['complemento_citado'],
							'cep' 					=> $pessoas['cep_citado'],
							'bairro' 				=> $pessoas['bairro_citado'],
							'cidade' 				=> $pessoas['cidade_citado'],
							'estado' 				=> $pessoas['estado_citado'],
							'notificar' 			=> $pessoas['notificar']//1 = sim //0 = nao
						);
						
					}
					
				}
				
				if($this->_request->getPost('submitfinal')){
					
					$user = new Zend_Session_Namespace('user_data');
				
					$data_historico['usuario'] = $user->user->idUsuario;
					$data_historico['idPedido'] = $idPedido;
					$data_historico['idItempedido'] = $idItempedido;
					$data_historico['descricao'] = 'Item registrado';
					
					$notificado = $_SESSION['pessoascitadas']['notificado'];
					$notificante = $_SESSION['pessoascitadas']['notificante'];
					unset($_SESSION['pessoascitadas']['notificado']);
					unset($_SESSION['pessoascitadas']['notificante']);
					
					$data_notificante = array(
						'tipo_identificacao'	=> $notificante['tipo_identificacao'],
						'numeroidentificacao'	=> preg_replace('/[^0-9]/', '', $notificante['numeroidentificacao']),	
						'nome' 					=> strtoupper ($notificante['nome']),
						'telefone' 				=> preg_replace('/[^0-9]/', '', $notificante['telefone']),
						'cep' 					=> preg_replace('/[^0-9]/', '', $notificante['cep']),
						'rua' 					=> strtoupper ($notificante['rua']),
						'complemento' 			=> strtoupper ($notificante['complemento']),
						'bairro' 				=> strtoupper ($notificante['bairro']),
						'numero' 				=> strtoupper ($notificante['numero']),
						'cidade' 				=> strtoupper ($notificante['cidade']),
						'observacoes' 			=> strtoupper ($notificante['observacoes'])
					);
					
					$data_notificado = array(
						'tipo_identificacao'	=> $notificado['tipo_identificacao'],
						'numeroidentificacao'	=> preg_replace('/[^0-9]/', '', $notificado['numeroidentificacao']),	
						'nome' 					=> strtoupper ($notificado['nome']),
						'telefone' 				=> preg_replace('/[^0-9]/', '', $notificado['telefone']),
						'cep' 					=> preg_replace('/[^0-9]/', '', $notificado['cep']),
						'rua' 					=> strtoupper ($notificado['rua']),
						'complemento' 			=> strtoupper ($notificado['complemento']),
						'bairro' 				=> strtoupper ($notificado['bairro']),
						'numero' 				=> strtoupper ($notificado['numero']),
						'cidade' 				=> strtoupper ($notificado['cidade']),
						'observacoes' 			=> strtoupper ($notificado['observacoes'])
					);
					
					$data_item = array(
						'idItempedido'			=> $idItempedido,
						'idTipodocumentos' 		=> preg_replace('/[^0-9]/', '', $this->_request->getPost('tipodocumentos')),
						'idEmolumentos'			=> preg_replace('/[^0-9]/', '', $this->_request->getPost('tipoemolumento')),
						'numeropaginas' 		=> preg_replace('/[^0-9]/', '', $this->_request->getPost('numeropaginas')),
						'numerovias' 			=> preg_replace('/[^0-9]/', '', $this->_request->getPost('numerovias')),
						'numeropessoas' 		=> preg_replace('/[^0-9]/', '', $this->_request->getPost('numeropessoas')),
						'valordocumento' 		=> str_replace(',', '.', str_replace('.', '',$this->_request->getPost('valordocumento'))),
						'valorcorreio' 			=> str_replace(',', '.', str_replace('.', '',$this->_request->getPost('valor_correio'))),
						'outrasdespesas' 		=> str_replace(',', '.', str_replace('.', '',$this->_request->getPost('outrasdespesas'))),
						'idSituacoes'			=> 2,
						'datasituacao'			=> date('Y-m-d'),
						'idPessoasnotificado' 	=> $this->cadastrarPessoa($data_notificado),	
						'idPessoasnotificante' 	=> $this->cadastrarPessoa($data_notificante)
					);
					
					$data_registro = array(
						'idProtocolo' => $idProtocolo,
						'idItempedido' => $idItempedido,
						'livro' => $this->_request->getPost('livro')
					);
					
					$this->updateItemPedido($data_item);
					
					$this->cadastrarRegistroPedido($data_registro);

					
					foreach($_SESSION['pessoascitadas'] as $pessoascitadas){
						
						$notificar = preg_replace('/[^0-9]/', '', $pessoascitadas['notificar']);
						$data_citado = array(
							'tipo_identificacao'	=> $pessoascitadas['tipo_identificacao'],
							'numeroidentificacao'	=> preg_replace('/[^0-9]/', '', $pessoascitadas['numeroidentificacao']),	
							'nome' 					=> strtoupper ($pessoascitadas['nome']),
							'telefone' 				=> preg_replace('/[^0-9]/', '', $pessoascitadas['telefone']),
							'cep' 					=> preg_replace('/[^0-9]/', '', $pessoascitadas['cep']),
							'rua' 					=> strtoupper ($pessoascitadas['rua']),
							'complemento' 			=> strtoupper ($pessoascitadas['complemento']),
							'bairro' 				=> strtoupper ($pessoascitadas['bairro']),
							'numero' 				=> strtoupper ($pessoascitadas['numero']),
							'cidade' 				=> strtoupper ($pessoascitadas['cidade']),
							'observacoes' 			=> strtoupper ($pessoascitadas['observacoes']),
							
						);
						$idPessoa = $this->cadastrarPessoa($data_citado);
						
						$data_pessoaCitada = array(
							'idPessoas' 	=> $idPessoa,
							'idItempedido' 	=> $idItempedido,
							'notificar' 	=> $notificar
						);
						
						$this->cadastrarPessoasCitadas($data_pessoaCitada);
					
					}
					
					unset($_SESSION['pessoascitadas']);
					
					$this->cadastrarHistoricoPedidos($data_historico);
					
					ZendX_JQuery_FlashMessenger::addMessage("Título cadastrado com sucesso.");
					$this->_redirect('/titulodocumentos/acompanhamento');
				}
				
				
			}
			
		$this->view->form = $form;
	
    }
	
	public function updateItemPedido($data)
	{
		
		$model_itempedido = new ItemPedidos();
    		  
        if($model_itempedido->update($data, "idItempedido = " . $data['idItempedido']))
        	return true;
        	
        return false;
		
	}
	
    public function cadastrarRegistroPedido($data)
    {
	
		if($data['livro'] == 1){
			
			unset($data['livro']);
			
			$model_registroA = new RegistroA();
		
			$model_registroA->insert($data);
		
			$registro['registro'] = $model_registroA->getAdapter()->lastInsertId();
		
			$model_registroA->update($registro, "idRegistro = " . $registro['registro']);
	
			return $registro['registro'];
			
		}
		else if($data['livro'] == 2){
			
			unset($data['livro']);
			
			$model_registroB = new RegistroB();
		
			$model_registroB->insert($data);
		
			$registro['registro'] = $model_registroB->getAdapter()->lastInsertId();
		
			$model_registroB->update($registro, "idRegistro = " . $registro['registro']);
	
			return $registro['registro'];
			
		}
		else if($data['livro'] == 3){
			
			unset($data['livro']);
			
			$model_registroC = new RegistroC();
		
			$model_registroC->insert($data);
		
			$registro['registro'] = $model_registroC->getAdapter()->lastInsertId();
		
			$model_registroC->update($registro, "idRegistro = " . $registro['registro']);
	
			return $registro['registro'];
			
		}
		else return false;
		
    }
	
	public function cadastrarPessoasCitadas($data)
    {
	
		$model_pessoaCitada = new Pessoascitadas();

		$model_pessoaCitada->insert($data);
		
		return true;
	
	}
	
	public function calculocustaAction()
    {
       $this->_helper->layout ()->disableLayout ();
	   $this->_helper->viewRenderer->setNoRender ();
		
		$idemolumento = (int) $this->_getParam('id');
		$valor = (int) $this->_getParam('valor');		
		
		$tipocustas = $this->model_tipoemolumento->getCustasTotais($idemolumento);
				
			if($tipocustas['tipo_custa'] == 1)
			{
				$emolumentos = $this->model_tabelaemolumentos->getEmolumento($valor);
				$emolumentos->toArray();
				$emolumentos = $emolumentos['emolumento'];
				
			
				$taxajudiciaria = $this->model_custas->getCustaByName('Taxa Judiciária');
				$funcivil = $this->model_custas->getCustaByName('Funcivil');
			
				$taxajudiciaria = str_replace(',', '.', $taxajudiciaria);
				$funcivil = str_replace(',', '.', $funcivil);
				$emolumentos = str_replace(',', '.', $emolumentos);
				
				$soma = $taxajudiciaria + $funcivil + $emolumentos;
				
				$custas = array('tipo_custa' => $tipocustas['tipo_custa'],'taxa'=>$taxajudiciaria, 'funcivil'=>$funcivil, 'emolumentos'=>$emolumentos, 'soma'=>$soma);
				
				echo Zend_Json::encode($custas);	
				$this->_helper->viewRenderer->setNoRender(true);
			}
			else if($tipocustas['tipo_custa'] == 0)
			{
				$taxajudiciaria = $this->model_custas->getCustaByName('Taxa Judiciária');
				$funcivil = $this->model_custas->getCustaByName('Funcivil');
				
				$taxajudiciaria =(int) str_replace(',', '', $taxajudiciaria);
				$funcivil =(int) str_replace(',', '', $funcivil);
				
				$valores = $this->model_emolumentofixo->getCustas($idemolumento)->toArray();
				$valores['tipo_custa'] = $tipocustas['tipo_custa'];
				$valores['funcivil'] = $funcivil;
				$valores['taxa'] = $taxajudiciaria;
				
				$valores['emolumento'] =(int) str_replace('.', '', $valores['emolumento']);
				$valores['pagina_extra'] =(int) str_replace('.', '', $valores['pagina_extra']);
				
				echo Zend_Json::encode($valores);	
				$this->_helper->viewRenderer->setNoRender(true);
			}
			else
				return false;
			exit();
    }

	function addDayIntoDate($date,$days) 
	{
		$thisyear = substr ( $date, 4, 4 );
		$thismonth = substr ( $date, 2, 2 );
		$thisday =  substr ( $date, 0, 2 );
		$nextdate = mktime ( 0, 0, 0, $thismonth, $thisday + $days, $thisyear );
		return strftime("%d%m%Y", $nextdate);
	}
}