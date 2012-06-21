<?php

class TitulodocumentosController extends Zend_Controller_Action
{

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
		
			if ( $this->_request->isPost()){
				
				$user = new Zend_Session_Namespace();
				
				$user->data_pedido						= $this->_request->getPost('data_pedido');
				$user->data_prevista					= $this->_request->getPost('data_prevista');
				$user->data_entrega						= $this->_request->getPost('data_entrega');
				$user->valor_pedido						= $this->_request->getPost('valor_pedido');
				$user->valor_deposito					= $this->_request->getPost('valor_deposito');
				$user->valor_receber					= $this->_request->getPost('valor_receber');
				$user->itens_pedido 					= $this->_request->getPost('itens_pedido');
				$user->tipo_identificacao_requerente	= $this->_request->getPost('tipo_identificacao_requerente');
				$user->documento_requerente				= $this->_request->getPost('documento_requerente');
				$user->nome_requerente					= $this->_request->getPost('nome_requerente');
				$user->telefone_requerente				= $this->_request->getPost('telefone_requerente');
				$user->cep_requerente					= $this->_request->getPost('cep_requerente');
				$user->endereco_requerente				= $this->_request->getPost('endereco_requerente');
				$user->complemento_requerente			= $this->_request->getPost('complemento_requerente');
				$user->bairro_requerente				= $this->_request->getPost('bairro_requerente');
				$user->numero_requerente				= $this->_request->getPost('numero_requerente');
				$user->estado_requerente 				= $this->_request->getPost('estado_requerente');
				$user->cidade_requerente				= $this->_request->getPost('cidade_requerente');
				$user->obs_requerente 					= $this->_request->getPost('obs_requerente');
				
				$form->data_pedido->setValue($user->data_pedido);
				$form->data_prevista->setValue($user->data_prevista);
				$form->data_entrega->setValue($user->data_entrega);
				$form->valor_pedido->setValue($user->valor_pedido);
				$form->valor_deposito->setValue($user->valor_deposito);
				$form->valor_receber->setValue($user->valor_receber);
				$form->itens_pedido->setValue($user->itens_pedido);
				$form->tipo_identificacao_requerente->setValue($user->tipo_identificacao_requerente);
				$form->documento_requerente->setValue($user->documento_requerente);
				$form->nome_requerente->setValue($user->nome_requerente);
				$form->telefone_requerente->setValue($user->telefone_requerente);
				$form->cep_requerente->setValue($user->cep_requerente);
				$form->endereco_requerente->setValue($user->endereco_requerente);
				$form->complemento_requerente->setValue($user->complemento_requerente);
				$form->bairro_requerente->setValue($user->bairro_requerente);
				$form->numero_requerente->setValue($user->numero_requerente);
				$form->estado_requerente->setValue($user->estado_requerente);
				$form->cidade_requerente->setValue($user->cidade_requerente);
				$form->obs_requerente->setValue($user->obs_requerente);
				
				$form1 = new Registro_Form_Pedido();
				
				$this->view->form = $form;
				$this->view->form = $form1->itensPedido();
				
			}
		
		$this->view->form = $form;
    }

    public function cadastrarpedidoAction()
    {
        // action body
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
}