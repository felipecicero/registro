<?php

class TitulodocumentosController extends Zend_Controller_Action
{

    private $model_pedidos = null;

    private $model_pedido = null;

    private $model_protocolo = null;

    private $model_historico = null;

    private $model_itempedido = null;

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
			
			$pedido['data_pedido']						= $this->_request->getPost('data_pedido');
			$pedido['data_prevista']					= $this->_request->getPost('data_prevista');
			$pedido['data_entrega']						= $this->_request->getPost('data_entrega');
			$pedido['idSituacoes']						= $this->_request->getPost('idSituacao');
			$pedido['valor_pedido']						= $this->_request->getPost('valor_pedido');
			$pedido['valor_deposito']					= $this->_request->getPost('valor_deposito');
			$pedido['valor_receber']					= $this->_request->getPost('valor_receber');
			$requerente['tipo_identificacao_requerente']= $this->_request->getPost('tipo_identificacao_requerente');
			$requerente['documento_requerente']			= $this->_request->getPost('documento_requerente');
			$requerente['nome_requerente']				= $this->_request->getPost('nome_requerente');
			$requerente['telefone_requerente']			= $this->_request->getPost('telefone_requerente');
			$requerente['cep_requerente']				= $this->_request->getPost('cep_requerente');
			$requerente['endereco_requerente']			= $this->_request->getPost('endereco_requerente');
			$requerente['complemento_requerente']		= $this->_request->getPost('complemento_requerente');
			$requerente['bairro_requerente']			= $this->_request->getPost('bairro_requerente');
			$requerente['numero_requerente']			= $this->_request->getPost('numero_requerente');
			$requerente['estado_requerente'] 			= $this->_request->getPost('estado_requerente');
			$requerente['cidade_requerente']			= $this->_request->getPost('cidade_requerente');
			$requerente['obs_requerente'] 				= $this->_request->getPost('obs_requerente');
						
			$form->data_pedido->setValue(date('d-m-Y'));
			$form->data_prevista->setValue($pedido['data_prevista']);
			$form->data_entrega->setValue($pedido['data_entrega']);
			$form->situacao->setValue($pedido['idSituacoes']);
			$form->valor_pedido->setValue($pedido['valor_pedido']);
			$form->valor_deposito->setValue($pedido['valor_deposito']);
			$form->valor_receber->setValue($pedido['valor_receber']);
			$form->tipo_identificacao_requerente->setValue($requerente['tipo_identificacao_requerente']);
			$form->documento_requerente->setValue($requerente['documento_requerente']);
			$form->nome_requerente->setValue($requerente['nome_requerente']);
			$form->telefone_requerente->setValue($requerente['telefone_requerente']);
			$form->cep_requerente->setValue($requerente['cep_requerente']);
			$form->endereco_requerente->setValue($requerente['endereco_requerente']);
			$form->complemento_requerente->setValue($requerente['complemento_requerente']);
			$form->bairro_requerente->setValue($requerente['bairro_requerente']);
			$form->numero_requerente->setValue($requerente['numero_requerente']);
			$form->estado_requerente->setValue($requerente['estado_requerente']);
			
			$model_cidade = new Cidade();
			$cidade = $model_cidade->findcity($this->_request->getPost('cidade_requerente'));
			
			$form->cidade_requerente->addMultiOption($cidade->idCidade, $cidade->nome);
			$form->cidade_requerente->setValue($cidade->nome);
			$form->obs_requerente->setValue($requerente['obs_requerente']);
			
			$this->view->form = $form;
			$this->view->form = $form->itensPedido();
			
			if ( $this->_request->getPost('adicionar') || $this->_request->getPost('submitfinal')){
					
				$itens['datasituacao']		= $this->_request->getPost('datasituacao');
				$itens['tipodocumentos']	= $this->_request->getPost('tipodocumentos');
				$itens['idSituacoes']		= $this->_request->getPost('pedido_situacao');
				$itens['tipoemolumento']	= $this->_request->getPost('tipoemolumento');
				$itens['numeropaginas']		= $this->_request->getPost('numeropaginas');
				$itens['numerovias']		= $this->_request->getPost('numerovias');
				$itens['numeropessoas']		= $this->_request->getPost('numeropessoas');
				$itens['valordocumento']	= $this->_request->getPost('valordocumento');
				$itens['emolumento']		= $this->_request->getPost('emolumento');
				$itens['valor_correio']		= $this->_request->getPost('valor_correio');
				$itens['outrasdespesas']	= $this->_request->getPost('outrasdespesas');
				$itens['total_custas']		= $this->_request->getPost('observacao');
				
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
					'dataentrega' 	=> preg_replace('/[^0-9]/', '', $pedido['data_entrega']),
					'valorpedido' 	=> preg_replace('/[^0-9]/', '', $pedido['valor_pedido']),
					'valordeposito' => preg_replace('/[^0-9]/', '', $pedido['valor_deposito']),
					'valorreceber' 	=> preg_replace('/[^0-9]/', '', $pedido['valor_receber']),
					'idSituacoes'	=> preg_replace('/[^0-9]/', '', $pedido['idSituacoes']),
					'idRequerente'	=> $this->cadastrarPessoa($data_requerente)
				);
				
				$idPedido = $this->cadastrarPedido($data_pedido);
				
				$data_historico['idPedido'] = $idPedido;

				
				foreach($_SESSION['itempedido'] as $itens){
				
					$data_itempedido = array(
						'idPedido' 			=> $idPedido,
						'idProtocolo' 		=> $this->getUltimoProtocolo(),
						'idTipodocumentos' 	=> preg_replace('/[^0-9]/', '', $itens['tipodocumentos']),
						'idEmolumentos' 	=> preg_replace('/[^0-9]/', '', $itens['tipoemolumento']),
						'idSituacoes	' 	=> preg_replace('/[^0-9]/', '', $itens['pedido_situacao']),
						'datasituacao' 		=> date('Y-m-d h:i:s'),
						'numeropaginas' 	=> preg_replace('/[^0-9]/', '', $itens['numeropaginas']),
						'numerovias' 		=> preg_replace('/[^0-9]/', '', $itens['numerovias']),
						'numeropessoas' 	=> preg_replace('/[^0-9]/', '', $itens['numeropessoas']),
						'valordocumento' 	=> preg_replace('/[^0-9]/', '', $itens['valordocumento']),
						'valorcorreio' 		=> preg_replace('/[^0-9]/', '', $itens['valor_correio']),
						'outrasdespesas' 	=> preg_replace('/[^0-9]/', '', $itens['outrasdespesas'])
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
        // action body
    }


}



