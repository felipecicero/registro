<?php

class Admin_CartorioController extends Zend_Controller_Action
{

    private $model_banco = null;
    private $model_cartorio = null;
    private $model_agencia = null;
    private $model_vigencia = null;
    private $model_tipoemolumento = null;
    private $model_tabelaemolumento = null;
    private $model_emolumentofixo = null;
    private $model_custa = null;
    private $model_feriado = null;
    private $model_abrangencia = null;
    private $model_selos = null;
    private $model_natureza = null;
    private $model_tipodocumento = null;

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
		
		$this->model_vigencia = new Vigencia();
		$this->model_custa = new Custa();
		$this->model_cartorio = new Cartorio();
		$this->model_banco = new Banco();
		$this->model_agencia = new Agencia();
		$this->model_tipoemolumento = new TipoEmolumento();
		$this->model_tabelaemolumento = new TabelaEmolumentos();
		$this->model_emolumentofixo = new Emolumentofixo();
		$this->model_feriado = new Feriado();
		$this->model_abrangencia = new Abrangencias();
		$this->model_selos = new Selo();
		$this->model_natureza = new Natureza();
		$this->model_tipodocumento = new Tipodocumento();
		
		$this->view->setEncoding('ISO-8859-1');//para nao dar problemas com acentuação dos formulários
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

    public function getagenciasAction()
    {
       $this->_helper->layout ()->disableLayout ();
	   $this->_helper->viewRenderer->setNoRender ();

	       	
	   $id = (int) $this->_getParam('idBanco');
	   $id = $_GET['id'];
       $model_agencia = new Agencia();
       $agencias = $model_agencia->findForSelect($id)->toArray();
       $combo = "<option value='0'>Carregando ... </option>";

       if (count($agencias) > 0) {           
       	   $combo = array ();
           $combo .= '<option value = "">Selecione a Agência</option>';
           foreach ( $agencias as $lista ) {           	
                  		$combo .= '<option value="' . $lista ['idAgencia'] . '">' . $lista['codigo'] . " - " . $lista ['descricao'] . '</option>';
           }
      }
      
      echo $combo;
    }

    public function getcidadesAction()
    {
       $this->_helper->layout ()->disableLayout ();
	   $this->_helper->viewRenderer->setNoRender ();

	       	
	   $id = (int) $this->_getParam('idEstado');
	   $id = $_GET['id'];
       $model_cidade = new Cidade();
       $cidades = $model_cidade->findForSelect($id)->toArray();
   	   //print_r($cidades);
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

    public function cadastrarendereco($data, $id = '')
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

    public function vigenciasAction()
    {
        $select =  $this->model_vigencia->select() 
                   		->setIntegrityCheck(false)               			
              			->order(array('vigencia DESC'));
        
    	$data = $this->model_vigencia->fetchAll($select);
    	
        $this->view->vigencias = $data;
    }

    public function cadastrarvigenciaAction()
    {
        $this->model_vigencia->getLastVigencia();
        $form = new Admin_Form_Vigencia();
        
        if ( $this->_request->isPost()){
	        	$data = array(
	        		'vigencia'  => $this->_request->getPost('vigencia'),	            	
	            );
	            	
	            if ( $form->isValid($data) ){
	            	$data['vigencia'] = implode("-", array_reverse(explode("/", $data['vigencia'])));
		             	            	
	            	
	            	if($this->model_vigencia->insert($data))
	            		ZendX_JQuery_FlashMessenger::addMessage('Dados cadastrados com sucesso.');
	           		 else 
	            		ZendX_JQuery_FlashMessenger::addMessage('Problemas ao cadastrar os dados.', 'error');	                
	                $this->_redirect('admin/cartorio/vigencias');
	            }
        }
        
        $form->vigencia->setValue(date('d/m/Y'));
        $this->view->form = $form;
    }

    public function deletarvigenciaAction()
    {
        // verificamos se realmente foi informado algum ID
        if ( $this->_hasParam('idVigencia') == false )
        {
            $this->_redirect('admin/cartorio/vigencias');
        }
 
        $id = (int) $this->_getParam('idVigencia');
        $where = $this->model_vigencia->getAdapter()->quoteInto('idVigencia = ?', $id);
         
        if($this->model_vigencia->delete($where))
            ZendX_JQuery_FlashMessenger::addMessage('Dados deletados com sucesso.');
        else 
            ZendX_JQuery_FlashMessenger::addMessage('Problemas ao deletar os dados.', 'error');
        
        $this->_redirect('admin/cartorio/vigencias');
    }

    public function editarvigenciaAction()
    {
        // action body
    }

    public function custasAction()
    {
        $idVigencia      = (int) $this->_getParam('idVigencia');
    	
    	$select =  $this->model_custa->select() 
                   		->setIntegrityCheck(false)
                   		->where("idVigencia = ?", $idVigencia)               			
              			->order(array('nome'));
        
    	$data = $this->model_custa->fetchAll($select);
    	
        $this->view->custas = $data;
    }

    public function cadastrarcustaAction()
    {
        $form = new Admin_Form_Custa();
        $idVigencia      = (int) $this->_getParam('idVigencia');

        if ( $this->_request->isPost()){
        	
        	$data = array(
        		'idVigencia'  => $idVigencia,
                'nome' => $this->_request->getPost('nome'),
        		'valor' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('valor')))	            	
            );
        	
            
            if($this->model_custa->insert($data))
	            		ZendX_JQuery_FlashMessenger::addMessage('Dados cadastrados com sucesso.');
            else 
            	ZendX_JQuery_FlashMessenger::addMessage('Problemas ao cadastrar os dados.', 'error');	                

        }
        
        //$form->idVigencia->setValue($idVigencia);
        $this->view->form = $form;
    }

    public function editarcustaAction()
    {
        $form = new Admin_Form_Custa();
    	
   		if ( $this->_request->isPost()){           
            $data = array(
            	'nome'  => $this->_request->getPost('nome'),
                'valor' => $this->_request->getPost('valor')
            );

            if ( $form->isValid($data) )
            {
            	$data['valor'] = str_replace(',', '.', str_replace('.', '', $data['valor']));
                
                if($this->model_custa->update($data, "idCusta = " . (int) $this->_request->getPost('idCusta')))
	            		ZendX_JQuery_FlashMessenger::addMessage('Dados alterados com sucesso.');
	            else 
	            		ZendX_JQuery_FlashMessenger::addMessage('Problemas ao alterados os dados.', 'error');
            	
                $this->_redirect('/admin/cartorio/custas/idVigencia/' . $this->_getParam('idVigencia')); 
            }
        }
        
    	$id      = (int) $this->_getParam('idCusta');     	    	      
        $result  = $this->model_custa->find($id);
        $data    = $result->current(); 
        //$this->_helper->Util->_pvar($data);        
		//$data['valor'] = str_replace(',', '.', str_replace('.', '', $data['valor']));
		
        if ( null === $data ){
            ZendX_JQuery_FlashMessenger::addMessage('Custa não encontrada!.', 'notice');
            return false;
        }
        
        $data->valor = $this->_helper->Util->valor($data->valor);
        $form->setAsEditForm($data);

        $this->view->form = $form;
    }

    public function deletarcustaAction()
    {
        // verificamos se realmente foi informado algum ID
        if ( $this->_hasParam('idCusta') == false )
        {
            $this->_redirect('admin/cartorio/custas');
        }
 
        $id = (int) $this->_getParam('idCusta');
        $where = $this->model_custa->getAdapter()->quoteInto('idCusta = ?', $id);
        if($this->model_custa->delete($where)){
        	ZendX_JQuery_FlashMessenger::addMessage('Custa deletada com sucesso.');        
        }
        else{
        	ZendX_JQuery_FlashMessenger::addMessage('Custa deletada com sucesso.');
        }
        $this->_redirect('admin/cartorio/custas');
    }

    public function feriadosAction()
    {
        $select =  $this -> model_feriado->select()              			
              			 -> order(array('date'));
        
    	$data = $this->model_feriado->fetchAll($select);
    	
        $this->view->feriados = $data;
    }

    public function cadastrarferiadoAction()
    {
        $form = new Admin_Form_Feriado();
        
        if ( $this->_request->isPost()){
	        	$data = array(
		        	'idFeriado'  => $this->_request->getPost('idFeriado'),
		        	'date'  => $this->_request->getPost('date'),
	                'descricao' => $this->_request->getPost('descricao')	            	
	            );
	
	            if ( $form->isValid($data) )
	            {
	            	$data['date'] = implode("-", array_reverse(explode("/", $data['date'])));
	            	
	            	$this->model_feriado->insert($data);	                
	                ZendX_JQuery_FlashMessenger::addMessage('Dados cadastrados com sucesso.');
	            }
	            
	            $form = new Admin_Form_Feriado();
        }
        
        $this->view->form = $form;
    }

    public function editarferiadoAction()
    {
        $form = new Admin_Form_Feriado();
    	
   		if ( $this->_request->isPost()){           
            $data = array(
		        	'idFeriado'  => $this->_request->getPost('idFeriado'),
		        	'date'  => $this->_request->getPost('date'),
	                'descricao' => $this->_request->getPost('descricao')	            	
	        );

            if ( $form->isValid($data) )
            { 
            	$data['date'] = implode("-", array_reverse(explode("/", $data['date'])));
            	               
                if($this->model_feriado->update($data, "idFeriado = " . $this->_request->getPost('idFeriado')))
           			 ZendX_JQuery_FlashMessenger::addMessage('Dados alterados com sucesso.');
	        	else 
	           	 	 ZendX_JQuery_FlashMessenger::addMessage('Problemas ao alterar os dados.', 'error');
                $this->_redirect('admin/cartorio/feriados');
            }
        }
        
    	$id      = (int) $this->_getParam('idFeriado');     	    	      
        $result  = $this->model_feriado->find($id);
        $data    = $result->current();         
		$data['date'] = implode("/", array_reverse(explode("-", $data['date'])));
		
        if ( null === $data ){
            ZendX_JQuery_FlashMessenger::addMessage('Feriado não encontrado.', 'notice');
            return false;
        }
        
        $form->setAsEditForm($data);

        $this->view->form = $form;
    }

    public function deletarferiadoAction()
    {
        if ( $this->_hasParam('idFeriado') == false )
        {
            $this->_redirect('/admin/cartorio/feriados');
        }
 
        $id = (int) $this->_getParam('idFeriado');
        $where = $this->model_feriado->getAdapter()->quoteInto('idFeriado = ?', $id);
        
        if($this->model_feriado->delete($where))
            ZendX_JQuery_FlashMessenger::addMessage('Dados deletados com sucesso.');
        else 
            ZendX_JQuery_FlashMessenger::addMessage('Problemas ao deletar os dados.', 'error');        
        $this->_redirect('/admin/cartorio/feriados');
    }

    public function abrangenciasAction()
    {
        $data =  $this->model_abrangencia->getAbrangencias();
            	
        $this->view->abrangencias = $data;
    }

    public function cadastrarabrangenciaAction()
    {
        $form = new Admin_Form_Abrangencias();
        
        if ( $this->_request->isPost()){
	        	$data = array(
	        		'idCidade'  => $this->_request->getPost('idCidade'),
	                'inicio' => $this->_request->getPost('inicio'),
	        		'limite' => $this->_request->getPost('limite')	            	
	            );
	            
	            
	            if($data['limite'] == ''){
	            	$data['limite'] = $data['inicio'];
	            }
	
	            if ( $form->isValid($data) ){
	            	$data['inicio'] = preg_replace('/[^0-9]/', '', $data['inicio']);
	            	$data['limite'] = preg_replace('/[^0-9]/', '', $data['limite']);
	            	
		             if($data['limite'] < $data['inicio']){
		            	$data['limite'] = $data['inicio'];
		             }
	            	
	            	if($this->model_abrangencia->insert($data))
	            		ZendX_JQuery_FlashMessenger::addMessage('Dados cadastrados com sucesso.');
	            	else 
	            		ZendX_JQuery_FlashMessenger::addMessage('Problemas ao cadastrar os dados.', 'error');	                

	            }
        }
        
        $this->view->form = $form;
    }

    public function deletarabrangenciaAction()
    {
        // verificamos se realmente foi informado algum ID
        if ( $this->_hasParam('idFaixacep') == false )
        {
            $this->_redirect('/admin/cartorio/abrangencias');
        }
 
        $id = (int) $this->_getParam('idFaixacep');
        $where = $this->model_abrangencia->getAdapter()->quoteInto('idFaixacep = ?', $id);
        
        if($this->model_abrangencia->delete($where))
            ZendX_JQuery_FlashMessenger::addMessage('Dados deletados com sucesso.');
        else 
            ZendX_JQuery_FlashMessenger::addMessage('Problemas ao deletar os dados.', 'error');        
        $this->_redirect('/admin/cartorio/abrangencias');
    }

    public function editarabrangenciaAction()
    {
        $form = new Admin_Form_Abrangencias();
    	
    	if ( $this->_request->isPost()){
	        	$data = array(
	        		'idCidade'  => $this->_request->getPost('idCidade'),
	                'inicio' => $this->_request->getPost('inicio'),
	        		'limite' => $this->_request->getPost('limite')	            	
	            );
	            
	            
	            if($data['limite'] == ''){
	            	$data['limite'] = $data['inicio'];
	            }
	
	            if ( $form->isValid($data) ){
	            	$data['inicio'] = preg_replace('/[^0-9]/', '', $data['inicio']);
	            	$data['limite'] = preg_replace('/[^0-9]/', '', $data['limite']);
	            	
		             if($data['inicio'] > $data['limite']){
		            	$data['limite'] = $data['inicio'];
		             }
	            	//print_r($data);exit;
	            	if($this->model_abrangencia->update($data, "idFaixacep = " . $this->_request->getPost('idFaixacep'))){	            	
	            		ZendX_JQuery_FlashMessenger::addMessage('Dados editados com sucesso.');
	            		$this->_redirect('/admin/cartorio/abrangencias');
	            	}
	            	else {
	            		ZendX_JQuery_FlashMessenger::addMessage('Problemas ao editar os dados.', 'error');
	            	}	                

	            }
        	}
        
    	$id      = (int) $this->_getParam('idFaixacep');     	    	      
        $result  = $this->model_abrangencia->find($id);
        $data    = $result->current();         
		
        if ( null === $data ){
            ZendX_JQuery_FlashMessenger::addMessage('Dados não encontrados.', 'error');
            return false;
        }
        
        $form->setAsEditForm($data);

        $this->view->form = $form;
    }

    public function selosAction()
    {
    	$select =  $this -> model_selos -> select() 
                   		 -> setIntegrityCheck(false);
        
    	$data = $this -> model_selos -> fetchAll($select);
    	
        $this -> view -> selos = $data;
    }

    public function cadastrarseloAction()
    {
        $form = new Admin_Form_Selo();

        if ( $this->_request->isPost()){
        	
        	$data = array(
        		'tipo' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('tipo'))),
				'serie' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('serie'))),
				'numeroinicial' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('numeroinicial'))),
        		'numerofinal' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('numerofinal'))),
        		'notafiscal' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('notafiscal'))),
        		'data_nota' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('data_nota'))),
        		'data_inclusao' => date('Y-m-d h:i:s'), 
        		'quantidade' => $this->_request->getPost('numerofinal') - $this->_request->getPost('numeroinicial')
            );
            
            if($data['numeroinicial'] >= $data['numerofinal']){
        			ZendX_JQuery_FlashMessenger::addMessage('O número inicial não deve ser maior que o final.', 'error');    	
            }
            else if($this->model_selos->insert($data))
           			 ZendX_JQuery_FlashMessenger::addMessage('Dados cadastrados com sucesso.');
        	else 
		           	 ZendX_JQuery_FlashMessenger::addMessage('Problemas ao cadastrar os dados.', 'error');
        }
        
        $this->view->form = $form;
    }

    public function editarseloAction()
    {
        $form = new Admin_Form_Selo();
    	
   		if ( $this->_request->isPost()){           
            $data = array(
        		'tipo' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('tipo'))),
				'serie' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('serie'))),
				'numeroinicial' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('numeroinicial'))),
        		'numerofinal' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('numerofinal'))),
        		'notafiscal' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('notafiscal'))),
        		'data_nota' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('data_nota')))
            );

            if($data['numeroinicial'] >= $data['numerofinal']){
        			ZendX_JQuery_FlashMessenger::addMessage('O número inicial não deve ser maior que o final.', 'error');    	
            }
            else if ( $form->isValid($data) )
            {
                if($this->model_selos->update($data, "idSelos = " . (int) $this->_request->getPost('idSelos')))
	            		ZendX_JQuery_FlashMessenger::addMessage('Dados alterados com sucesso.');
	            else 
	            		ZendX_JQuery_FlashMessenger::addMessage('Problemas ao alterados os dados.', 'error');
            	
                $this->_redirect('/admin/cartorio/selos'); 
            }
        }
        
    	$id      = (int) $this->_getParam('idSelos');     	    	      
        $result  = $this->model_selos->find($id);
        $data    = $result->current(); 
        //$this->_helper->Util->_pvar($data);        
		//$data['valor'] = str_replace(',', '.', str_replace('.', '', $data['valor']));
		
        if ( null === $data ){
            ZendX_JQuery_FlashMessenger::addMessage('Lote não encontrado!.', 'notice');
            return false;
        }
        
        $form->setAsEditForm($data);

        $this->view->form = $form;
    }

    public function deletarseloAction()
    {
       // verificamos se realmente foi informado algum ID
        if ( $this->_hasParam('idSelos') == false )
        {
            $this->_redirect('admin/cartorio/selos');
        }
 
        $id = (int) $this->_getParam('idSelos');
        $where = $this->model_custa->getAdapter()->quoteInto('idSelos = ?', $id);
        if($this->model_selos->delete($where)){
        	ZendX_JQuery_FlashMessenger::addMessage('Lote de selos deletado com sucesso.');        
        }
        else{
        	ZendX_JQuery_FlashMessenger::addMessage('Problemas ao deletar os dados.', 'error');
        }
        $this->_redirect('admin/cartorio/selos');
    }

    public function naturezaAction()
    {
        $select =  $this->model_natureza->select() 
                   		->setIntegrityCheck(false)               			
              			->order(array('nome'));
        
    	$data = $this->model_natureza->fetchAll($select);
    	
        $this->view->naturezas = $data;
    }

    public function cadastrarnaturezaAction()
    {
        $form = new Admin_Form_Natureza();
        
        if ( $this->_request->isPost()){
        	$data = array(
                'nome'		 => $this->_request->getPost('nome')    	
            );
        	
            if($this->model_natureza->insert($data))
	            		ZendX_JQuery_FlashMessenger::addMessage('Dados cadastrados com sucesso.');
            else 
            	ZendX_JQuery_FlashMessenger::addMessage('Problemas ao cadastrar os dados.', 'error');	                

        }
        
        //$form->idVigencia->setValue($idVigencia);
        $this->view->form = $form;
    }

    public function editarnaturezaAction()
    {
        // action body
    }

    public function deletarnaturezaAction()
    {
       // verificamos se realmente foi informado algum ID
        if ( $this->_hasParam('idNatureza') == false )
        {
            $this->_redirect('admin/cartorio/natureza');
        }
 
        $id = (int) $this->_getParam('idNatureza');
        $where = $this->model_natureza->getAdapter()->quoteInto('idNatureza = ?', $id);
         
        if($this->model_natureza->delete($where))
            ZendX_JQuery_FlashMessenger::addMessage('Dados deletados com sucesso.');
        else 
            ZendX_JQuery_FlashMessenger::addMessage('Problemas ao deletar os dados.', 'error');
        
        $this->_redirect('admin/cartorio/natureza');
    }

    public function tipodocumentosAction()
    {
        $data = $this->model_tipodocumento->selectTipos();
    	
        $this->view->tipodocumentos = $data;
    }

    public function cadastrartipodocumentosAction()
    {
        $form = new Admin_Form_Tipodocumento();
        
        if ( $this->_request->isPost()){
        	$data = array(
        		'idNatureza' => $this->_request->getPost('idNatureza'),
				'nome' => $this->_request->getPost('nome')
            );
        	
            if($this->model_tipodocumento->insert($data))
           			 ZendX_JQuery_FlashMessenger::addMessage('Dados cadastrados com sucesso.');
        	else 
           	 ZendX_JQuery_FlashMessenger::addMessage('Problemas ao cadastrar os dados.', 'error');
        }
       
        $this->view->form = $form;
    }

    public function editartipodocumentosAction()
    {
        // action body
    }

    public function deletartipodocumentosAction()
    {
        // verificamos se realmente foi informado algum ID
        if ( $this->_hasParam('idTipodocumentos') == false )
        {
            $this->_redirect('/admin/cartorio/tipodocumentos/idTipodocumentos/' . $this->_getParam('idTipodocumentos'));
        }
 
        $id = (int) $this->_getParam('idTipodocumentos');
        $where = $this->model_tipodocumento->getAdapter()->quoteInto('idTipodocumentos = ?', $id);
        
        if($this->model_tipodocumento->delete($where))
            ZendX_JQuery_FlashMessenger::addMessage('Dados deletados com sucesso.');
        else 
            ZendX_JQuery_FlashMessenger::addMessage('Problemas ao deletar os dados.', 'error');
            
        $this->_redirect('/admin/cartorio/tipodocumentos/idTipodocumentos/' . $this->_getParam('idTipodocumentos'));
    }

    public function emolumentofixoAction()
    {
        $idEmolumentos = (int) $this->_getParam('idEmolumentos');    	
    	$data =  $this->model_emolumentofixo->verificaCusta($idEmolumentos);
		
		
		if(isset($data->idTipoEmolumento)){
			
			$custa = $this->model_emolumentofixo->getCusta($data->idEmolumentoFixo);
			
			$this->view->emolumentofixo = $custa;
		}
		else {
			$this->view->emolumentofixo = null;
			$this->view->idemolumento = $idEmolumentos;
		}
		
    }

    public function cadastraremolumentofixoAction()
    {
		
		$idEmolumento = (int) $this->_getParam('idEmolumentos');
	
		$model_emolumento = new TipoEmolumento();
		
		$emo = $model_emolumento->findForSelect($idEmolumento);

		$form = new Admin_Form_Emolumentofixo();
		
        if ( $this->_request->isPost()){
		
        	$data = array(
        		'idTipoEmolumento' => $idEmolumento,
        		'pagina_extra' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('pagina_extra'))),
				'pagina_inicial' => $this->_request->getPost('pagina_inicial'),
				'emolumento' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('emolumento')))
            );
			
            if($this->model_emolumentofixo->insert($data))
           			 ZendX_JQuery_FlashMessenger::addMessage('Dados cadastrados com sucesso.');
        	else 
           	 ZendX_JQuery_FlashMessenger::addMessage('Problemas ao cadastrar os dados.', 'error');
        }
        
        $form->idTipoEmolumento->setValue($emo->emolumento);
        $this->view->form = $form;
    }

    public function editaremolumentofixoAction()
    {
        // action body
    }

    public function deletaremolumentofixoAction()
    {
        // action body
    }

    public function custasdocsAction()
    {
        // action body
    }

    public function tabelaemolumentosAction()
    {
        $idVigencia      = (int) $this->_getParam('idVigencia');    	
    	$select =  $this->model_tabelaemolumento->select() 
                   		->setIntegrityCheck(false)
                   		->where("idVigencia = ?", $idVigencia)               			
              			->order(array('emolumento'));
        
    	$data = $this->model_tabelaemolumento->fetchAll($select);
    	
        $this->view->emolumentos = $data;
    }

    public function cadastrartabelaemolumentosAction()
    {
        $form = new Admin_Form_TabelaEmolumentos();
        $idVigencia = (int) $this->_getParam('idVigencia');

        if ( $this->_request->isPost()){
        	
        	$data = array(
        		'idVigencia'  => $idVigencia,
        		'valor_inicial' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('valor_inicial'))),
				'valor_final' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('valor_final'))),
				'emolumento' => str_replace(',', '.', str_replace('.', '', $this->_request->getPost('emolumento')))
            );
        	
            if($this->model_tabelaemolumento->insert($data))
           			 ZendX_JQuery_FlashMessenger::addMessage('Dados cadastrados com sucesso.');
        	else 
           	 ZendX_JQuery_FlashMessenger::addMessage('Problemas ao cadastrar os dados.', 'error');
        }
        
        $form->idVigencia->setValue($idVigencia);
        $this->view->form = $form;
    }

    public function editartabelaemolumentosAction()
    {
        $form = new Admin_Form_TabelaEmolumentos();
    	
   		if ( $this->_request->isPost()){           
            $data = array(
                'emolumento' => $this->_request->getPost('emolumento'),
        		'valor_inicial' => $this->_request->getPost('valor_inicial'),
				'valor_final' => $this->_request->getPost('valor_final')
            );

            if ( $form->isValid($data) )
            {
            	$data['valor_inicial'] = str_replace(',', '.', str_replace('.', '', $this->_request->getPost('valor_inicial')));
				$data['valor_final'] = str_replace(',', '.', str_replace('.', '', $this->_request->getPost('valor_final')));
				$data['emolumento'] = str_replace(',', '.', str_replace('.', '', $this->_request->getPost('emolumento')));
            	
                if($this->model_tabelaemolumento->update($data, "idTabelaEmolumento = " . (int) $this->_request->getPost('idTabelaEmolumento')))
           			 ZendX_JQuery_FlashMessenger::addMessage('Dados alterados com sucesso.');
	        	else 
	           	 	 ZendX_JQuery_FlashMessenger::addMessage('Problemas ao alterar os dados.', 'error');
                
                $this->_redirect('/admin/cartorio/emolumentos/idVigencia/' . $this->_getParam('idVigencia'));
            }
        }
        
    	$id      = (int) $this->_getParam('idTabelaEmolumento');     	    	      
        $result  = $this->model_emolumento->find($id);
        $data    = $result->current();         
		
        if ( null === $data ){
        	ZendX_JQuery_FlashMessenger::addMessage('Emolumento não encontrado!', 'notice');
            return false;
        }
        
        $data->valor_inicial = $this->_helper->Util->valor($data->valor_inicial);
        $data->valor_final = $this->_helper->Util->valor($data->valor_final);
        $data->emolumento = $this->_helper->Util->valor($data->emolumento);
        $form->setAsEditForm($data);

        $this->view->form = $form;
    }

    public function deletartabelaemolumentosAction()
    {
        // verificamos se realmente foi informado algum ID
        if ( $this->_hasParam('idTabelaEmolumento') == false )
        {
            $this->_redirect('/admin/cartorio/emolumentos/idVigencia/' . $this->_getParam('idVigencia'));
        }
 
        $id = (int) $this->_getParam('idTabelaEmolumento');
        $where = $this->model_tabelaemolumento->getAdapter()->quoteInto('idTabelaEmolumento = ?', $id);
        
        if($this->model_emolumento->delete($where))
            ZendX_JQuery_FlashMessenger::addMessage('Dados deletados com sucesso.');
        else 
            ZendX_JQuery_FlashMessenger::addMessage('Problemas ao deletar os dados.', 'error');
            
        $this->_redirect('/admin/cartorio/emolumentos/idVigencia/' . $this->_getParam('idVigencia'));
    }

	public function tipoemolumentosAction()
    {
        $idVigencia      = (int) $this->_getParam('idVigencia');    	
    	$data =  $this->model_tipoemolumento->selectTipos();
		
        $this->view->emolumentos = $data;
    }

    public function cadastrartipoemolumentoAction()
    {
        $form = new Admin_Form_TipoEmolumento();
		$idVigencia = (int) $this->_getParam('idVigencia');
		
		
        if ( $this->_request->isPost()){
		
			if ((string) $this->_request->getPost('valor') == '0,01')
				$valor = 1;
			else 
				$valor = 0;
        	
        	$data = array(
        		'idVigencia' => $idVigencia,
        		'idNatureza' => $this->_request->getPost('idNatureza'),
				'tipo_custa' => $valor,
				'emolumento' => $this->_request->getPost('emolumentos')
            );
            if($this->model_tipoemolumento->insert($data))
           			 ZendX_JQuery_FlashMessenger::addMessage('Dados cadastrados com sucesso.');
        	else 
           	 ZendX_JQuery_FlashMessenger::addMessage('Problemas ao cadastrar os dados.', 'error');
        }
        
        $form->idVigencia->setValue($idVigencia);
        $this->view->form = $form;
    }

    public function editartipoemolumentoAction()
    {
        $form = new Admin_Form_TipoEmolumento();
    	
   		if ( $this->_request->isPost()){           
            $data = array(
                'emolumentos' => $this->_request->getPost('emolumentos'),
        		'valorinicial' => $this->_request->getPost('valorinicial'),
				'valorfinal' => $this->_request->getPost('valorfinal')
            );

            if ( $form->isValid($data) )
            {
            	$data['valorinicial'] = str_replace(',', '.', str_replace('.', '', $this->_request->getPost('valorinicial')));
				$data['valorfinal'] = str_replace(',', '.', str_replace('.', '', $this->_request->getPost('valorfinal')));
				$data['emolumentos'] = str_replace(',', '.', str_replace('.', '', $this->_request->getPost('emolumentos')));
            	
                if($this->model_tipoemolumento->update($data, "idEmolumentos = " . (int) $this->_request->getPost('idEmolumentos')))
           			 ZendX_JQuery_FlashMessenger::addMessage('Dados alterados com sucesso.');
	        	else 
	           	 	 ZendX_JQuery_FlashMessenger::addMessage('Problemas ao alterar os dados.', 'error');
                
                $this->_redirect('/admin/cartorio/tipoemolumentos/idVigencia/' . $this->_getParam('idVigencia'));
            }
        }
        
    	$id      = (int) $this->_getParam('idEmolumentos');     	    	      
        $result  = $this->model_tipoemolumento->find($id);
        $data    = $result->current();         
		
        if ( null === $data ){
        	ZendX_JQuery_FlashMessenger::addMessage('Emolumento não encontrado!', 'notice');
            return false;
        }
        
        $data->valorinicial = $this->_helper->Util->valor($data->valorinicial);
        $data->valorfinal = $this->_helper->Util->valor($data->valorfinal);
        $data->emolumentos = $this->_helper->Util->valor($data->emolumentos);
        $form->setAsEditForm($data);

        $this->view->form = $form;
    }

    public function deletartipoemolumentoAction()
    {
        // verificamos se realmente foi informado algum ID
        if ( $this->_hasParam('idEmolumentos') == false )
        {
            $this->_redirect('/admin/cartorio/tipoemolumentos/idVigencia/' . $this->_getParam('idVigencia'));
        }
 
        $id = (int) $this->_getParam('idEmolumentos');
        $where = $this->model_tipoemolumento->getAdapter()->quoteInto('idEmolumentos = ?', $id);
        
        if($this->model_tipoemolumento->delete($where))
            ZendX_JQuery_FlashMessenger::addMessage('Dados deletados com sucesso.');
        else 
            ZendX_JQuery_FlashMessenger::addMessage('Problemas ao deletar os dados.', 'error');
            
        $this->_redirect('/admin/cartorio/tipoemolumentos/idVigencia/' . $this->_getParam('idVigencia'));
    }

	
	
}

















