<?php

class Registro_Form_Pedido extends Zend_Form
{

    public function init()
    {
        $this->setDecorators(array( 'FormElements', 'Form')); 
		$decorator_default = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field')));
		$decorator_check = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field checkbox')));
		$decorator_margin = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field margin')));
		$decorator_textarea = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field textarea')));
		$decorator_option = array('ViewHelper','Errors','Label',array(array('row' => 'HtmlTag'),array('class' => 'option-field')));
		
		$model_pedidos = new Pedidos();
	    $pedido = new Zend_Form_Element_Select('idPedido');
		$pedido -> clearDecorators();
		$pedido -> addDecorators($decorator_default);
		$pedido -> setLabel('Pedido:');
		$pedido -> setAttrib('disabled', 'disabled');
		$pedido -> setAttrib('class', 'half');
	    foreach ($model_pedidos->findForSelect() as $pedi) {
	    	$pedido -> addMultiOption($pedi->idPedido, $this->completa(10, $pedi->pedido, "0"));
		}
		
		$model_situacao = new Situacoes();
	    $situacao = new Zend_Form_Element_Select('idSituacao');
		$situacao -> clearDecorators();
		$situacao -> addDecorators($decorator_default);
		$situacao -> setLabel('Situação:');
		$situacao -> setAttrib('disabled', 'disabled');
		$situacao -> setAttrib('class', 'half');
	    foreach ($model_situacao->findForSelect() as $situa) {
	    	$situacao->addMultiOption($situa->idSituacoes, $situa->nome);
		}
	
		$validate = new Zend_Validate_Date(array('locale' => 'pt-Br'));
    	$data_pedido = new Zend_Form_Element_Text('data_pedido');
		$data_pedido -> clearDecorators();
		$data_pedido -> addDecorators($decorator_default);
    	$data_pedido -> setLabel("Data do Pedido:");
		$data_pedido -> setAttrib('class', 'half');
    	$data_pedido -> setAttrib('maxlength', '10');
    	$data_pedido -> setAttrib('onKeyDown', 'Mascara(this,mdata);');
    	$data_pedido -> setAttrib('onKeyPress', 'Mascara(this,mdata);');
    	$data_pedido -> setAttrib('onKeyUp', 'Mascara(this,mdata);');
    	$data_pedido -> addValidator($validate);
    	$data_pedido -> setRequired(true);
		
		$validator_date = new Validate_DateHJ();
		
    	$data_prevista = new Zend_Form_Element_Text('data_prevista');
		$data_prevista -> clearDecorators();
		$data_prevista -> addDecorators($decorator_default);
    	$data_prevista -> setLabel("Data Prevista:");
		$data_prevista -> setAttrib('class', 'half');
    	$data_prevista -> setAttrib('maxlength', '10');
    	$data_prevista -> setAttrib('onKeyDown', 'Mascara(this,mdata);');
    	$data_prevista -> setAttrib('onKeyPress', 'Mascara(this,mdata);');
    	$data_prevista -> setAttrib('onKeyUp', 'Mascara(this,mdata);');
    	$data_prevista -> addValidator($validate);
    	$data_prevista -> addValidator($validator_date);
    	$data_prevista -> setRequired(true);
		
		$data_entrega = new Zend_Form_Element_Text('data_entrega');
		$data_entrega -> clearDecorators();
		$data_entrega -> addDecorators($decorator_default);
    	$data_entrega -> setLabel("Data Entrega:");
		$data_entrega -> setAttrib('class', 'half');
    	$data_entrega -> setAttrib('maxlength', '10');
    	$data_entrega -> setAttrib('onKeyDown', 'Mascara(this,mdata);');
    	$data_entrega -> setAttrib('onKeyPress', 'Mascara(this,mdata);');
    	$data_entrega -> setAttrib('onKeyUp', 'Mascara(this,mdata);');
    	$data_entrega -> addValidator($validate);
    	$data_entrega -> addValidator($validator_date);
    	$data_entrega -> setRequired(true);
		
		$valor_pedido = new Zend_Form_Element_Text('valor_pedido');
		$valor_pedido -> clearDecorators();
		$valor_pedido -> addDecorators($decorator_default);
    	$valor_pedido -> setLabel("Valor do Pedido:");
		$valor_pedido -> setAttrib('class', 'half');
    	$valor_pedido -> setRequired(true);
		
		$valor_deposito = new Zend_Form_Element_Text('valor_deposito');
		$valor_deposito -> clearDecorators();
		$valor_deposito -> addDecorators($decorator_default);
    	$valor_deposito -> setLabel("Valor do Depósito:");
		$valor_deposito -> setAttrib('class', 'half');
    	$valor_deposito -> setRequired(true);
		
		$valor_receber = new Zend_Form_Element_Text('valor_receber');
		$valor_receber -> clearDecorators();
		$valor_receber -> addDecorators($decorator_default);
    	$valor_receber -> setLabel("Valor à Receber:");
		$valor_receber -> setAttrib('class', 'half');
    	$valor_receber -> setRequired(true);
		
		$itens_pedido = new Zend_Form_Element_Text('itens_pedido');
		$itens_pedido -> clearDecorators();
		$itens_pedido -> addDecorators($decorator_default);
    	$itens_pedido -> setLabel("Número de Itens do Pedido:");
		$itens_pedido -> setAttrib('class', 'half');
    	$itens_pedido -> setRequired(true);
		
		//Requerente
		
    	$tipo_identificacao_requerente = new Zend_Form_Element_Radio('tipo_identificacao_requerente');
		$tipo_identificacao_requerente -> clearDecorators();
		$tipo_identificacao_requerente -> addDecorators($decorator_default);
        $tipo_identificacao_requerente -> setLabel('Tipo do documento:');
        $tipo_identificacao_requerente -> addMultiOptions(array(
													'1' => 'CNPJ',
													'2' => 'CPF'));
      	$tipo_identificacao_requerente -> setSeparator('');
      	$tipo_identificacao_requerente -> setValue('1');
         
    	$documento_requerente = new Zend_Form_Element_Text('documento_requerente');
		$documento_requerente -> clearDecorators();
		$documento_requerente -> addDecorators($decorator_default);
    	$documento_requerente -> setLabel("Documento:");
		$documento_requerente -> setAttrib('class', 'half');
                  
        $nome_requerente = new Zend_Form_Element_Text('nome_requerente');
		$nome_requerente -> clearDecorators();
		$nome_requerente -> addDecorators($decorator_default);
    	$nome_requerente -> setLabel("Nome:");
		$nome_requerente -> setAttrib('class', 'half');
    		 
    	$cep_requerente = new Zend_Form_Element_Text('cep_requerente');
		$cep_requerente -> clearDecorators();
		$cep_requerente -> addDecorators($decorator_default);
    	$cep_requerente -> setLabel("CEP:");
		$cep_requerente -> setAttrib('class', 'half');
    	
    	$endereco_requerente = new Zend_Form_Element_Text('endereco_requerente');
		$endereco_requerente -> clearDecorators();
		$endereco_requerente -> addDecorators($decorator_default);
    	$endereco_requerente -> setLabel("Endereço:");
		$endereco_requerente -> setAttrib('class', 'half');
						
						
		$telefone_requerente = new Zend_Form_Element_Text('telefone_requerente');
		$telefone_requerente -> clearDecorators();
		$telefone_requerente -> addDecorators($decorator_default);
    	$telefone_requerente -> setLabel("Telefone:");
    	$telefone_requerente -> setAttrib('size', '14');
		

    	$complemento_requerente = new Zend_Form_Element_Text('complemento_requerente');
		$complemento_requerente -> clearDecorators();
		$complemento_requerente -> addDecorators($decorator_default);
    	$complemento_requerente -> setLabel("Complemento:");
		$complemento_requerente -> setAttrib('class', 'half');
    		 
    	$bairro_requerente = new Zend_Form_Element_Text('bairro_requerente');
		$bairro_requerente -> clearDecorators();
		$bairro_requerente -> addDecorators($decorator_default);
    	$bairro_requerente -> setLabel("Bairro:");
		$bairro_requerente -> setAttrib('class', 'half');
    		 
    	$numero_requerente = new Zend_Form_Element_Text('numero_requerente');
		$numero_requerente -> clearDecorators();
		$numero_requerente -> addDecorators($decorator_default);
    	$numero_requerente -> setLabel("Número:");
		$numero_requerente -> setAttrib('class', 'half');
    	
		$model_estado = new Estado();
    	$estado_requerente = new Zend_Form_Element_Select('estado_requerente');
		$estado_requerente -> clearDecorators();
		$estado_requerente -> addDecorators($decorator_default);
		$estado_requerente -> setLabel('UF:');
		$estado_requerente -> setAttrib('class', 'half');
		$estado_requerente -> setRequired(true);
		$estado_requerente -> addMultiOption('0', 'Selecione o Estado');		
	    foreach ($model_estado->findForSelect() as $uf) {
	    	$estado_requerente -> addMultiOption($uf->idEstado, $uf->sigla);
		} 
    		    		 		   	 
    	$cidade_requerente = new Zend_Form_Element_Select('cidade_requerente');
    	$cidade_requerente -> clearDecorators();
		$cidade_requerente -> addDecorators($decorator_default);
		$cidade_requerente -> setLabel("Cidade:");
		$cidade_requerente -> setAttrib('class', 'half');
        
		$obs_requerente = new Zend_Form_Element_Textarea('obs_requerente');
		$obs_requerente -> clearDecorators();
		$obs_requerente -> addDecorators($decorator_textarea);
        $obs_requerente -> setLabel('Observações:');
		$obs_requerente -> setAttrib('rows','5');
		$obs_requerente -> setAttrib('cols','40');
		$obs_requerente -> addFilter('StripTags');
		
		$submit = new Zend_Form_Element_Submit('Salvar');
        $submit -> setAttrib('id', 'submitbutton-import');
		$submit -> clearDecorators();
		$submit -> setDecorators(array('ViewHelper'));
		
		$this->addElements(array($pedido, $situacao, $data_pedido, $data_prevista, $data_entrega, $valor_pedido, $valor_deposito, $valor_receber, $itens_pedido));
		
		$this->addElements(array($tipo_identificacao_requerente, $documento_requerente, $nome_requerente, $telefone_requerente, $cep_requerente, 
								$endereco_requerente, $complemento_requerente, $bairro_requerente, $numero_requerente, 
								$estado_requerente, $cidade_requerente, $obs_requerente));
		
		$this->addElements(array($submit));	
		
		
	}

	public function itensPedido(){
		
		$this->setDecorators(array( 'FormElements', 'Form')); 
		$decorator_default = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field')));
		$decorator_check = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field checkbox')));
		$decorator_margin = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field margin')));
		$decorator_textarea = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field textarea')));
		$decorator_option = array('ViewHelper','Errors','Label',array(array('row' => 'HtmlTag'),array('class' => 'option-field')));
		
		$model_itempedido = new ItemPedidos();
	    $item_pedido = new Zend_Form_Element_Select('idItempedido');
		$item_pedido -> clearDecorators();
		$item_pedido -> addDecorators($decorator_default);
		$item_pedido -> setLabel('Item do Pedido:');
		$item_pedido -> setAttrib('disabled', 'disabled');
		$item_pedido -> setAttrib('class', 'half');
	    foreach ($model_itempedido->findForSelect() as $item) {
	    	$item_pedido -> addMultiOption($item->idItempedido, $this->_helper->Util->completa(10, $item->itempedido, "0"));
		}
		
		$model_situacao = new Situacoes();
	    $pedido_situacao = new Zend_Form_Element_Select('idSituacao');
		$pedido_situacao -> clearDecorators();
		$pedido_situacao -> addDecorators($decorator_default);
		$pedido_situacao -> setLabel('Situação:');
		$pedido_situacao -> setAttrib('disabled', 'disabled');
		$pedido_situacao -> setAttrib('class', 'half');
	    foreach ($model_situacao->findForSelect() as $situa) {
	    	$pedido_situacao -> addMultiOption($situa->idSituacoes, $situa->nome);
		}
		
		$data_situacao = new Zend_Form_Element_Text('datasituacao');
		$data_situacao -> clearDecorators();
		$data_situacao -> addDecorators($decorator_default);
    	$data_situacao -> setLabel("Data Da Situação:");
		$data_situacao -> setAttrib('class', 'half');
    	$data_situacao -> setAttrib('maxlength', '10');
    	$data_situacao -> setAttrib('onKeyDown', 'Mascara(this,mdata);');
    	$data_situacao -> setAttrib('onKeyPress', 'Mascara(this,mdata);');
    	$data_situacao -> setAttrib('onKeyUp', 'Mascara(this,mdata);');
    	$data_situacao -> addValidator($validate);
    	$data_situacao -> addValidator($validator_date);
    	$data_situacao -> setRequired(true);
		
		$model_tipodocumento = new Tipodocumento();
	    $tipodocumentos = new Zend_Form_Element_Select('tipodocumentos');
		$tipodocumentos -> clearDecorators();
		$tipodocumentos -> addDecorators($decorator_default);
		$tipodocumentos -> setLabel('Tipo do Docuemento:');
		$tipodocumentos -> setAttrib('class', 'half');
	    foreach ($model_tipodocumento->findForSelect() as $tdoc) {
	    	$tipodocumentos -> addMultiOption($tdoc->idTipodocumentos, $tdoc->nome);
		}
		
		$model_tipoemolumento = new TipoEmolumento();
	    $tipoemolumento = new Zend_Form_Element_Select('tipoemolumento');
		$tipoemolumento -> clearDecorators();
		$tipoemolumento -> addDecorators($decorator_default);
		$tipoemolumento -> setLabel('Tipo do Emolumento:');
		$tipoemolumento -> setAttrib('class', 'half');
	    foreach ($model_tipoemolumento->findForSelectForm() as $temo) {
	    	$tipoemolumento -> addMultiOption($temo->idEmolumentos, $temo->emolumento);
		}
		
		$numeropaginas = new Zend_Form_Element_Text('numeropaginas');
		$numeropaginas -> clearDecorators();
		$numeropaginas -> addDecorators($decorator_default);
    	$numeropaginas -> setLabel("Número de Páginas:");
		$numeropaginas -> setAttrib('class', 'half');
    	$numeropaginas -> setRequired(true);
		
		$numerovias = new Zend_Form_Element_Text('numerovias');
		$numerovias -> clearDecorators();
		$numerovias -> addDecorators($decorator_default);
    	$numerovias -> setLabel("Número de Vias:");
		$numerovias -> setAttrib('class', 'half');
    	$numerovias -> setRequired(true);
		
		$numeropessoas = new Zend_Form_Element_Text('numeropessoas');
		$numeropessoas -> clearDecorators();
		$numeropessoas -> addDecorators($decorator_default);
    	$numeropessoas -> setLabel("Número de Pessoas Notificadas:");
		$numeropessoas -> setAttrib('class', 'half');
    	$numeropessoas -> setRequired(true);
		
		$valor_documento = new Zend_Form_Element_Text('valordocumento');
		$valor_documento -> clearDecorators();
		$valor_documento -> addDecorators($decorator_default);
    	$valor_documento -> setLabel("Valor do Documento:");
		$valor_documento -> setAttrib('class', 'half');
    	$valor_documento -> setRequired(true);
		
		$emolumento = new Zend_Form_Element_Text('emolumento');
		$emolumento -> clearDecorators();
		$emolumento -> addDecorators($decorator_default);
    	$emolumento -> setLabel("Emolumento:");
		$emolumento -> setAttrib('class', 'half');
    	$emolumento -> setRequired(true);
		
		$valor_correio = new Zend_Form_Element_Text('valor_correio');
		$valor_correio -> clearDecorators();
		$valor_correio -> addDecorators($decorator_default);
    	$valor_correio -> setLabel("Valor dos Correios:");
		$valor_correio -> setAttrib('class', 'half');
    	$valor_correio -> setRequired(true);
		
		$outras_despesas = new Zend_Form_Element_Text('outrasdespesas');
		$outras_despesas -> clearDecorators();
		$outras_despesas -> addDecorators($decorator_default);
    	$outras_despesas -> setLabel("Outras Despesas:");
		$outras_despesas -> setAttrib('class', 'half');
    	$outras_despesas -> setRequired(true);
		
		$valor = $model_custa->getCustaByName('taxa judiciária');
    	$taxa_judiciaria = new Zend_Form_Element_Text('taxajudiciaria');
		$taxa_judiciaria -> clearDecorators();
		$taxa_judiciaria -> addDecorators($decorator_default);
    	$taxa_judiciaria -> setLabel("Taxa Judiciária:");
		$taxa_judiciaria -> setAttrib('class', 'half');
    	$taxa_judiciaria -> setAttrib('disabled', 'disabled');
    	$taxa_judiciaria -> setValue($valor);
		
		$valorf = $model_custa->getCustaByName('funcivil');
    	$funcivil = new Zend_Form_Element_Text('funcivil');
		$funcivil -> clearDecorators();
		$funcivil -> addDecorators($decorator_default);
    	$funcivil -> setLabel("FUNCIVIL:");
		$funcivil -> setAttrib('class', 'half');
    	$funcivil -> setAttrib('disabled', 'disabled');
    	$funcivil -> setValue($valorf);
		
		$total_custas = new Zend_Form_Element_Text('total_custas');
		$total_custas -> clearDecorators();
		$total_custas -> addDecorators($decorator_default);
    	$total_custas -> setLabel("Total das Custas:");
		$total_custas -> setAttrib('class', 'half');
    	$total_custas -> setRequired(true);
		
		$observacao = new Zend_Form_Element_Textarea('observacao');
		$observacao -> clearDecorators();
		$observacao -> addDecorators($decorator_textarea);
        $observacao -> setLabel('Observações:');
		$observacao -> setAttrib('rows','5');
		$observacao -> setAttrib('cols','40');
		$observacao -> addFilter('StripTags');
		
		$submit = new Zend_Form_Element_Submit('Salvar');
        $submit -> setAttrib('id', 'submitbutton-import');
		$submit -> clearDecorators();
		$submit -> setDecorators(array('ViewHelper'));
		
		$this->addElements(array($item_pedido, $pedido_situacao, $data_situacao, $tipodocumentos, $tipoemolumento, $numeropaginas, $numerovias, $numeropessoas, $valor_documento, $emolumento, $valor_correio, $outras_despesas, $taxa_judiciaria, $funcivil, $total_custas, $observacao, $submit));
		
	}
	
	public function completa($tamanho, $string, $complemento){
		
		$tamanho_string = strlen($string);
		
		if($complemento == "0"){
			while($tamanho_string < $tamanho){
				$string = $complemento.$string;
				$tamanho_string = strlen($string);
			}
		}
		else{
			while($tamanho_string < $tamanho){
				$string = $string.$complemento;
				$tamanho_string = strlen($string);
			}
		}
		return $string;
	}
}

