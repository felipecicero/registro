<?php

class Admin_CartorioController extends Zend_Controller_Action
{

    private $model_banco = null;

    private $model_cartorio = null;

    private $model_agencia = null;

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
	    	$this->_redirect('/protesto/index');	    	
	    }
	    
       	parent::init();
		
		$this->model_cartorio = new Cartorio();
		$this->model_banco = new Banco();
		$this->model_agencia = new Agencia();
    }

    public function indexAction()
    {
        
    }

    public function cadastrarcartorioAction()
    {
        $form = new Admin_Form_Cartorio();
        
        if ( $this->_request->isPost()){
	        	$data = array(
	        		'nome'  => $this->_request->getPost('nome'),
	                'nomefantasia' => $this->_request->getPost('nomefantasia'),	        	
	        		'codigo' => $this->_request->getPost('codigo'),
	        		'telefone' => preg_replace('/[^0-9]/', '', $this->_request->getPost('telefone')),
	        		'email' => $this->_request->getPost('email'),
	        		'site' => $this->_request->getPost('site'),
	        		'idAgencia' => 	$this->_request->getPost('idAgencia'),
	        		'conta' => 	$this->_request->getPost('conta'),
	        		'carteira' => 	$this->_request->getPost('carteira'),
	        		'cnpj' => 	preg_replace('/[^0-9]/', '', $this->_request->getPost('cnpj')),
	        		'tabeliao' => $this->_request->getPost('tabeliao'),
            		'substituto' => $this->_request->getPost('substituto'),
            		'escrevente' => $this->_request->getPost('escrevente'),
	        		'notificacao' => $this->_request->getPost('notificacao'),
	        	
	        		'cep'  => $this->_request->getPost('cep'),
	                'rua' => $this->_request->getPost('endereco'),	        	
	        		'complemento' => $this->_request->getPost('complemento'),
	        		'bairro' => $this->_request->getPost('bairro'),
	        		'numero' => $this->_request->getPost('numero'),
	        		'idCidade' => $this->_request->getPost('idCidade')
	        	
	        		
	        	
	            );
	            

	            
	            if ( $form->isValid($data) )
	            {
	            	$data_endereco = $data;
	            	unset($data_endereco['nome']);unset($data_endereco['nomefantasia']); unset($data_endereco['codigo']); 
	            	unset($data_endereco['telefone']); unset($data_endereco['email']); unset($data_endereco['site']);  
					unset($data_endereco['idAgencia']);unset($data_endereco['conta']);unset($data_endereco['carteira']);
	            	unset($data_endereco['cnpj']);unset($data_endereco['tabeliao']);unset($data_endereco['substituto']);
	            	unset($data_endereco['escrevente']);unset($data_endereco['notificacao']);
	            	
	            	unset($data['cep']);unset($data['rua']); unset($data['complemento']); 
	            	unset($data['bairro']); unset($data['numero']); unset($data['idCidade']);  
	            	unset($data['estado']);
	            	
	            	
	            	$data['idEndereco'] = $this->cadastrarendereco($data_endereco);
	            	
	            	if($this->model_cartorio->insert($data))	  
		                ZendX_JQuery_FlashMessenger::addMessage('Dados cadastrados com sucesso.');
		            else ZendX_JQuery_FlashMessenger::addMessage('Problemas ao cadastrar os dados.', 'error');
	            }
        }
        
        $this->view->form = $form;
    }

    public function editarcartorioAction()
    {
        $form = new Admin_Form_Cartorio();

    	$result  = $this->model_cartorio->getCartorio();
        $data    = $this->model_cartorio->getCartorio();//$result->current();		
        $id = $data->idCartorio;
		
        if ( null === $data )
        {
            $this->view->message = "Cartório não encontrado!";
            return false;
        }
 		
        $form->setAsEditForm($data);
    	
    	if ( $this->_request->isPost() ){
            $data = array(
	        		'nome'  => $this->_request->getPost('nome'),
	                'nomefantasia' => $this->_request->getPost('nomefantasia'),	        	
	        		'codigo' => $this->_request->getPost('codigo'),
	        		'telefone' => preg_replace('/[^0-9]/', '', $this->_request->getPost('telefone')),
	        		'email' => $this->_request->getPost('email'),
	        		'site' => $this->_request->getPost('site'),
            		'idAgencia' => $this->_request->getPost('idAgencia'),
            		'conta' => $this->_request->getPost('conta'),
            		'carteira' => $this->_request->getPost('carteira'),            		
            		'cnpj' => 	preg_replace('/[^0-9]/', '', $this->_request->getPost('cnpj')),
            	    'tabeliao' => $this->_request->getPost('tabeliao'),
            		'substituto' => $this->_request->getPost('substituto'),
            		'escrevente' => $this->_request->getPost('escrevente'),
            		'notificacao' => $this->_request->getPost('notificacao'),
	        		
	        		'cep'  => $this->_request->getPost('cep'),
	                'rua' => $this->_request->getPost('endereco'),	        	
	        		'complemento' => $this->_request->getPost('complemento'),
	        		'bairro' => $this->_request->getPost('bairro'),
	        		'numero' => $this->_request->getPost('numero'),
	        		'idCidade' => $this->_request->getPost('idCidade')	
	         );

            if ( $form->isValid($data) )
            {
            	$data_endereco = $data;
            	unset($data_endereco['nome']);unset($data_endereco['nomefantasia']); unset($data_endereco['codigo']); 
            	unset($data_endereco['telefone']); unset($data_endereco['email']); unset($data_endereco['site']);
            	unset($data_endereco['idAgencia']); unset($data_endereco['conta']); unset($data_endereco['carteira']);
            	unset($data_endereco['cnpj']);unset($data_endereco['tabeliao']);unset($data_endereco['substituto']);
	            	unset($data_endereco['escrevente']);unset($data_endereco['notificacao']);
	            	
            	unset($data['cep']);unset($data['rua']); unset($data['complemento']); 
            	unset($data['bairro']); unset($data['numero']); unset($data['idCidade']);  
            	
            	$data['idEndereco'] = $this->cadastrarendereco( $data_endereco, $this->_request->getPost('idEndereco')); 

                if($this->model_cartorio->update($data, "idCartorio = " . $id))
	            		ZendX_JQuery_FlashMessenger::addMessage('Dados alterados com sucesso.');
	            else 
	            		ZendX_JQuery_FlashMessenger::addMessage('Problemas ao alterar os dados.', 'error');
				$this->_redirect('/admin/cartorio');
                
            }
        }

        $this->view->form = $form;
    }

    public function bancosAction()
    {
        $select =  $this->model_banco->select()              			
              			->order(array('codigo'));
        
    	$data = $this->model_banco->fetchAll($select);
    	
        $this->view->bancos = $data;
    }

    public function cadastrarbancoAction()
    {
        $form = new Admin_Form_Banco();
        
        if ( $this->_request->isPost()){
	        	$data = array(
	                'nome'  => $this->_request->getPost('nome'),
	                'codigo' => $this->_request->getPost('codigo')	            	
	            );
	
	            if ( $form->isValid($data) )
	            {
	            	$this->model_banco->insert($data);
	            	ZendX_JQuery_FlashMessenger::addMessage('Dados cadastrados com sucesso.');
	            }
        }
        
        $this->view->form = $form;
    }

    public function editarbancoAction()
    {
        $form = new Admin_Form_Banco();
    	
   		if ( $this->_request->isPost()){           
            $data = array(
	                'nome'  => $this->_request->getPost('nome'),
	                'codigo' => $this->_request->getPost('codigo')	            	
	         );

            if ( $form->isValid($data) )
            {
                
                if($this->model_banco->update($data, "idBanco = " . $this->_request->getPost('idBanco')))
           			 ZendX_JQuery_FlashMessenger::addMessage('Dados alterados com sucesso.');
	        	else 
	           	 	 ZendX_JQuery_FlashMessenger::addMessage('Problemas ao alterar os dados.', 'error');
	           	 	 
                $this->_redirect('/admin/cartorio/bancos/idBanco/' . $this->_getParam('idBanco'));
            }
        }
        
    	$id      = (int) $this->_getParam('idBanco');     	    	      
        $result  = $this->model_banco->find($id);
        $data    = $result->current();         
		
        if ( null === $data ){
            $this->view->message = "Banco não encontrado!";
            return false;
        }
        
        $form->setAsEditForm($data);

        $this->view->form = $form;
    }

    public function deletarbancoAction()
    {
        // verificamos se realmente foi informado algum ID
        if ( $this->_hasParam('idBanco') == false )
        {
            $this->_redirect('/admin/cartorio/bancos/idBanco/' . $this->_getParam('idBanco'));
        }
 
        $id = (int) $this->_getParam('idBanco');
        $where = $this->model_banco->getAdapter()->quoteInto('idBanco = ?', $id);
        
        if($this->model_banco->delete($where))
            ZendX_JQuery_FlashMessenger::addMessage('Dados deletados com sucesso.');
        else 
            ZendX_JQuery_FlashMessenger::addMessage('Problemas ao deletar os dados.', 'error');        
        $this->_redirect('/admin/cartorio/bancos/idBanco/' . $this->_getParam('idBanco'));
    
    }

    public function cadastraragenciaAction()
    {
        $form = new Admin_Form_Agencia();
        
        if ( $this->_request->isPost()){
	        	$data = array(
		        	'idBanco'  => $this->_request->getPost('idBanco'),
		        	'codigo'  => $this->_request->getPost('codigo'),
	                'descricao' => $this->_request->getPost('descricao')	            	
	            );
	
	            if ( $form->isValid($data) )
	            {
	            	$this->model_agencia->insert($data);	                
	                ZendX_JQuery_FlashMessenger::addMessage('Dados cadastrados com sucesso.');
	                $this->_redirect('/admin/cartorio/agencias/idBanco/' . $this->_getParam('idBanco'));
	            }
        }
        
        $this->view->form = $form;
    }

    public function deletaragenciaAction()
    {
        if ( $this->_hasParam('idAgencia') == false )
        {
            $this->_redirect('/admin/cartorio/agencias/idBanco/' . $this->_getParam('idBanco'));
        }
 
        $id = (int) $this->_getParam('idAgencia');
        $where = $this->model_agencia->getAdapter()->quoteInto('idAgencia = ?', $id);
          
        if($this->model_agencia->delete($where))
            ZendX_JQuery_FlashMessenger::addMessage('Dados deletados com sucesso.');
        else 
            ZendX_JQuery_FlashMessenger::addMessage('Problemas ao deletar os dados.', 'error');     
        $this->_redirect('/admin/cartorio/agencias/idBanco/' . $this->_getParam('idBanco'));
    }

    public function editaragenciaAction()
    {
        $form = new Admin_Form_agencia();
    	
   		if ( $this->_request->isPost()){           
            $data = array(
	                'codigo'  => $this->_request->getPost('codigo'),
            		'idBanco'  => $this->_request->getPost('idBanco'),
	                'descricao' => $this->_request->getPost('descricao')	            	
	         );

            if ( $form->isValid($data) )
            {                
                if($this->model_agencia->update($data, "idAgencia = " . $this->_request->getPost('idAgencia')))
           			 ZendX_JQuery_FlashMessenger::addMessage('Dados alterados com sucesso.');
	        	else 
	           	 	 ZendX_JQuery_FlashMessenger::addMessage('Problemas ao alterar os dados.', 'error');
                	$this->_redirect('/admin/cartorio/agencias/idBanco/' . $this->_getParam('idBanco'));
            }
        }
        
    	$id      = (int) $this->_getParam('idAgencia');     	    	      
        $result  = $this->model_agencia->find($id);
        $data    = $result->current();         
		//print_r($data);exit;
        if ( null === $data ){
            ZendX_JQuery_FlashMessenger::addMessage('Agência não encontrada.', 'notice');
            return false;
        }
        
        $form->setAsEditForm($data);

        $this->view->form = $form;
    }

    public function agenciasAction()
    {
        $idBanco      = (int) $this->_getParam('idBanco');
    	
    	$select =  $this->model_agencia->select() 
                   		->setIntegrityCheck(false)
                   		->where("idBanco = ?", $idBanco)               			
              			->order(array('descricao'));
        
    	$data = $this->model_agencia->fetchAll($select);
    	
        $this->view->agencias = $data;
    }


}























