<?php

class Registro_Form_Pedido extends Zend_Form
{
    public function init()
    {
		$this->setDecorators(array('FormElements', 'Form'));

		$decorator_default = array( 'ViewHelper', 'Errors',  array( 'Description',  array(  'tag' => 'p', 'class' => 'description' ) ), 'Label', array( array('data' => 'HtmlTag'), array( 'tag' => 'div', 'class' => 'field' ) ) );

		$decorator_check = array('ViewHelper','Errors','Description','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field checkbox')));
		$decorator_margin = array('ViewHelper','Errors','Description','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field margin')));
		$decorator_textarea = array('ViewHelper','Errors','Description','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field textarea')));
		$decorator_option = array('ViewHelper','Errors','Label',array(array('row' => 'HtmlTag'),array('class' => 'option-field')));

		$model_pedido = new Pedido();
	    $pedido = new Zend_Form_Element_Select('idPedido');
		$pedido -> clearDecorators();
		$pedido -> addDecorators($decorator_default);
		$pedido -> setLabel('Pedido:');
		$pedido -> setAttrib('disabled', 'disabled');
		$pedido -> setAttrib('class', 'half');
	    foreach ($model_pedido->findForSelect() as $pedi) {
	    	$pedido -> addMultiOption($pedi->idPedido, $this->completa(10, $pedi->pedido, "0"));
		}

		$model_situacao = new Situacoes();
	    $situacao = new Zend_Form_Element_Select('idSituacao');
		$situacao -> clearDecorators();
		$situacao -> addDecorators($decorator_default);
		$situacao -> setLabel('Situação:');
		//$situacao -> setAttrib('disabled', 'disabled');
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

		$submit = new Zend_Form_Element_Submit('Salvar');
        $submit -> setAttrib('class', 'button-submit');
		$submit -> clearDecorators();
		$submit -> setDecorators(array('ViewHelper'));

		$submit_temp = new Zend_Form_Element_Submit('adicionar');
		$submit_temp -> setAttrib('class', 'button-submit');
		$submit_temp -> clearDecorators();
		$submit_temp -> setDecorators(array('ViewHelper'));

		$submit_final = new Zend_Form_Element_Submit('submitfinal');
		$submit_final -> setAttrib('class', 'button-submit');
		$submit_final -> clearDecorators();
		$submit_final -> setDecorators(array('ViewHelper'));			

		$this->addElements(array($pedido, $situacao, $data_pedido, $data_prevista, $data_entrega, $valor_pedido, 
							$valor_deposito, $valor_receber));

		$this->addDisplayGroup( 
			array('idPedido', 'idSituacao', 'data_pedido', 'data_prevista', 'data_entrega', 'valor_pedido','valor_deposito','valor_receber'), 'contact',
			array('legend' => 'Cadastro de pedido', 'id'=>'cadastro-pedido-form')
		);

		$displayGroup = $this->getDisplayGroup('contact');
		$displayGroup -> removeDecorator('DtDdWrapper');

		//Sub Form Pessoa Requerente

		$requerente = new Zend_Form_SubForm();

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
		$cidade_requerente -> setRegisterInArrayValidator(false);
		$cidade_requerente -> setRequired(true);

		$obs_requerente = new Zend_Form_Element_Textarea('obs_requerente');
		$obs_requerente -> clearDecorators();
		$obs_requerente -> addDecorators($decorator_textarea);
		$obs_requerente -> setLabel('Observações:');
		$obs_requerente -> setAttrib('rows','5');
		$obs_requerente -> setAttrib('cols','40');
		$obs_requerente -> addFilter('StripTags');

		$requerente->setLegend('Requerente');

		$requerente->addElements(array(	$tipo_identificacao_requerente, $documento_requerente, $nome_requerente, 
										$telefone_requerente, $cep_requerente, $endereco_requerente, 
										$complemento_requerente, $bairro_requerente, $numero_requerente, 
										$estado_requerente, $cidade_requerente, $obs_requerente));

		$this->addSubForm($requerente, 'Requerente');

		$displayGroup = $this->getSubForm('Requerente');
		$displayGroup -> removeDecorator('DtDdWrapper');

		$this->addElements(array($submit, $submit_temp, $submit_final));

		$this->addDisplayGroup( 
			array('Salvar', 'adicionar', 'submitfinal'), 'submits',
			array('legend' => '', 'id'=>'submits-form')
		);

		$displayGroup = $this->getDisplayGroup('submits');
		$displayGroup -> removeDecorator('DtDdWrapper');
	}

	public function itensPedido(){
		$this->setDecorators(array('FormElements', 'Form'));

		$decorator_default = array( 'ViewHelper', 'Errors',  array( 'Description',  array(  'tag' => 'p', 'class' => 'description' ) ), 'Label', array( array('data' => 'HtmlTag'), array( 'tag' => 'div', 'class' => 'field' ) ) );

		$decorator_check = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field checkbox')));
		$decorator_margin = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field margin')));
		$decorator_textarea = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field textarea')));
		$decorator_option = array('ViewHelper','Errors','Label',array(array('row' => 'HtmlTag'),array('class' => 'option-field')));

		$itenspedido = new Zend_Form_SubForm();
		$itenspedido -> removeDecorator('DtDdWrapper');

		$model_protocolo = new Protocolo();
		$item_pedido = new Zend_Form_Element_Select('idItempedido');
		$item_pedido -> clearDecorators();
		$item_pedido -> addDecorators($decorator_default);
		$item_pedido -> setLabel('Item do Pedido:');
		$item_pedido -> setAttrib('disabled', 'disabled');
		$item_pedido -> setAttrib('class', 'half');
		foreach ($model_protocolo->findForSelect() as $item) {
			$item_pedido -> addMultiOption($item->idProtocolo, $this->completa(10, $item->protocolo, "0"));
		}

		$model_situacao = new Situacoes();
		$pedido_situacao = new Zend_Form_Element_Select('pedido_situacao');
		$pedido_situacao -> clearDecorators();
		$pedido_situacao -> addDecorators($decorator_default);
		$pedido_situacao -> setLabel('Situação:');
		//$pedido_situacao -> setAttrib('disabled', 'disabled');
		$pedido_situacao -> setAttrib('class', 'half');
		foreach ($model_situacao->findForSelect() as $situa) {
			$pedido_situacao -> addMultiOption($situa->idSituacoes, $situa->nome);
		}

		$validate = new Zend_Validate_Date(array('locale' => 'pt-Br'));
		$validator_date = new Validate_DateHJ();
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


		$model_custa = new Custa();
		$valor = $model_custa->getCustaByName('taxa_judiciária');
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

		$itenspedido->setLegend('Itens do Pedido');

		$itenspedido->addElements(array($item_pedido, $pedido_situacao, $data_situacao, $tipodocumentos, $tipoemolumento, 
										$numeropaginas, $numerovias, $numeropessoas, $valor_documento, $emolumento, 
										$valor_correio, $outras_despesas, $taxa_judiciaria, $funcivil, $total_custas, 
										$observacao));

		$this->addSubForm($itenspedido, 'itempedido');
		
		$SF = $this->getSubForm('itempedido');
		$SF -> removeDecorator('DtDdWrapper');

		$notificante = new Zend_Form_SubForm();

		$tipo_identificacao_notificante = new Zend_Form_Element_Radio('tipo_identificacao_notificante');
		$tipo_identificacao_notificante -> clearDecorators();
		$tipo_identificacao_notificante -> addDecorators($decorator_default);
		$tipo_identificacao_notificante -> setLabel('Tipo do documento:');
		$tipo_identificacao_notificante -> addMultiOptions(array(
													'1' => 'CNPJ',
													'2' => 'CPF'));
		$tipo_identificacao_notificante -> setSeparator('');
		$tipo_identificacao_notificante -> setValue('1');

		$documento_notificante = new Zend_Form_Element_Text('documento_notificante');
		$documento_notificante -> clearDecorators();
		$documento_notificante -> addDecorators($decorator_default);
		$documento_notificante -> setLabel("Documento:");
		$documento_notificante -> setAttrib('class', 'half');

		$nome_notificante = new Zend_Form_Element_Text('nome_notificante');
		$nome_notificante -> clearDecorators();
		$nome_notificante -> addDecorators($decorator_default);
		$nome_notificante -> setLabel("Nome:");
		$nome_notificante -> setAttrib('class', 'half');

		$cep_notificante = new Zend_Form_Element_Text('cep_notificante');
		$cep_notificante -> clearDecorators();
		$cep_notificante -> addDecorators($decorator_default);
		$cep_notificante -> setLabel("CEP:");
		$cep_notificante -> setAttrib('class', 'half');

		$endereco_notificante = new Zend_Form_Element_Text('endereco_notificante');
		$endereco_notificante -> clearDecorators();
		$endereco_notificante -> addDecorators($decorator_default);
		$endereco_notificante -> setLabel("Endereço:");
		$endereco_notificante -> setAttrib('class', 'half');


		$telefone_notificante = new Zend_Form_Element_Text('telefone_notificante');
		$telefone_notificante -> clearDecorators();
		$telefone_notificante -> addDecorators($decorator_default);
		$telefone_notificante -> setLabel("Telefone:");
		$telefone_notificante -> setAttrib('size', '14');


		$complemento_notificante = new Zend_Form_Element_Text('complemento_notificante');
		$complemento_notificante -> clearDecorators();
		$complemento_notificante -> addDecorators($decorator_default);
		$complemento_notificante -> setLabel("Complemento:");
		$complemento_notificante -> setAttrib('class', 'half');

		$bairro_notificante = new Zend_Form_Element_Text('bairro_notificante');
		$bairro_notificante -> clearDecorators();
		$bairro_notificante -> addDecorators($decorator_default);
		$bairro_notificante -> setLabel("Bairro:");
		$bairro_notificante -> setAttrib('class', 'half');

		$numero_notificante = new Zend_Form_Element_Text('numero_notificante');
		$numero_notificante -> clearDecorators();
		$numero_notificante -> addDecorators($decorator_default);
		$numero_notificante -> setLabel("Número:");
		$numero_notificante -> setAttrib('class', 'half');

		$model_estado = new Estado();
		$estado_notificante = new Zend_Form_Element_Select('estado_notificante');
		$estado_notificante -> clearDecorators();
		$estado_notificante -> addDecorators($decorator_default);
		$estado_notificante -> setLabel('UF:');
		$estado_notificante -> setAttrib('class', 'half');
		$estado_notificante -> setRequired(true);
		$estado_notificante -> addMultiOption('0', 'Selecione o Estado');		
		foreach ($model_estado->findForSelect() as $uf) {
			$estado_notificante -> addMultiOption($uf->idEstado, $uf->sigla);
		} 

		$cidade_notificante = new Zend_Form_Element_Select('cidade_notificante');
		$cidade_notificante -> clearDecorators();
		$cidade_notificante -> addDecorators($decorator_default);
		$cidade_notificante -> setLabel("Cidade:");
		$cidade_notificante -> setAttrib('class', 'half');
		$cidade_notificante -> setRegisterInArrayValidator(false);
		$cidade_notificante -> setRequired(true);

		$obs_notificante = new Zend_Form_Element_Textarea('obs_notificante');
		$obs_notificante -> clearDecorators();
		$obs_notificante -> addDecorators($decorator_textarea);
		$obs_notificante -> setLabel('Observações:');
		$obs_notificante -> setAttrib('rows','5');
		$obs_notificante -> setAttrib('cols','40');
		$obs_notificante -> addFilter('StripTags');

		$notificante->addElements(array($tipo_identificacao_notificante, $documento_notificante, $nome_notificante, 
								$telefone_notificante, $cep_notificante, $endereco_notificante, $complemento_notificante, 
								$bairro_notificante, $numero_notificante, $estado_notificante, $cidade_notificante, 
								$obs_notificante));

		$notificante->setLegend('Notificante');

		$itenspedido->addSubForm($notificante, 'notificante');
		$SF = $itenspedido->getSubForm('notificante');
		$SF->removeDecorator('DtDdWrapper');



		$notificado = new Zend_Form_SubForm();

		$tipo_identificacao_notificado = new Zend_Form_Element_Radio('tipo_identificacao_notificado');
		$tipo_identificacao_notificado -> clearDecorators();
		$tipo_identificacao_notificado -> addDecorators($decorator_default);
		$tipo_identificacao_notificado -> setLabel('Tipo do documento:');
		$tipo_identificacao_notificado -> addMultiOptions(array(
													'1' => 'CNPJ',
													'2' => 'CPF'));
		$tipo_identificacao_notificado -> setSeparator('');
		$tipo_identificacao_notificado -> setValue('1');

		$documento_notificado = new Zend_Form_Element_Text('documento_notificado');
		$documento_notificado -> clearDecorators();
		$documento_notificado -> addDecorators($decorator_default);
		$documento_notificado -> setLabel("Documento:");
		$documento_notificado -> setAttrib('class', 'half');

		$nome_notificado = new Zend_Form_Element_Text('nome_notificado');
		$nome_notificado -> clearDecorators();
		$nome_notificado -> addDecorators($decorator_default);
		$nome_notificado -> setLabel("Nome:");
		$nome_notificado -> setAttrib('class', 'half');

		$cep_notificado = new Zend_Form_Element_Text('cep_notificado');
		$cep_notificado -> clearDecorators();
		$cep_notificado -> addDecorators($decorator_default);
		$cep_notificado -> setLabel("CEP:");
		$cep_notificado -> setAttrib('class', 'half');

		$endereco_notificado = new Zend_Form_Element_Text('endereco_notificado');
		$endereco_notificado -> clearDecorators();
		$endereco_notificado -> addDecorators($decorator_default);
		$endereco_notificado -> setLabel("Endereço:");
		$endereco_notificado -> setAttrib('class', 'half');


		$telefone_notificado = new Zend_Form_Element_Text('telefone_notificado');
		$telefone_notificado -> clearDecorators();
		$telefone_notificado -> addDecorators($decorator_default);
		$telefone_notificado -> setLabel("Telefone:");
		$telefone_notificado -> setAttrib('size', '14');


		$complemento_notificado = new Zend_Form_Element_Text('complemento_notificado');
		$complemento_notificado -> clearDecorators();
		$complemento_notificado -> addDecorators($decorator_default);
		$complemento_notificado -> setLabel("Complemento:");
		$complemento_notificado -> setAttrib('class', 'half');

		$bairro_notificado = new Zend_Form_Element_Text('bairro_notificado');
		$bairro_notificado -> clearDecorators();
		$bairro_notificado -> addDecorators($decorator_default);
		$bairro_notificado -> setLabel("Bairro:");
		$bairro_notificado -> setAttrib('class', 'half');

		$numero_notificado = new Zend_Form_Element_Text('numero_notificado');
		$numero_notificado -> clearDecorators();
		$numero_notificado -> addDecorators($decorator_default);
		$numero_notificado -> setLabel("Número:");
		$numero_notificado -> setAttrib('class', 'half');

		$model_estado = new Estado();
		$estado_notificado = new Zend_Form_Element_Select('estado_notificado');
		$estado_notificado -> clearDecorators();
		$estado_notificado -> addDecorators($decorator_default);
		$estado_notificado -> setLabel('UF:');
		$estado_notificado -> setAttrib('class', 'half');
		$estado_notificado -> setRequired(true);
		$estado_notificado -> addMultiOption('0', 'Selecione o Estado');		
		foreach ($model_estado->findForSelect() as $uf) {
			$estado_notificado -> addMultiOption($uf->idEstado, $uf->sigla);
		} 

		$cidade_notificado = new Zend_Form_Element_Select('cidade_notificado');
		$cidade_notificado -> clearDecorators();
		$cidade_notificado -> addDecorators($decorator_default);
		$cidade_notificado -> setLabel("Cidade:");
		$cidade_notificado -> setAttrib('class', 'half');
		$cidade_notificado -> setRegisterInArrayValidator(false);
		$cidade_notificado -> setRequired(true);

		$obs_notificado = new Zend_Form_Element_Textarea('obs_notificado');
		$obs_notificado -> clearDecorators();
		$obs_notificado -> addDecorators($decorator_textarea);
		$obs_notificado -> setLabel('Observações:');
		$obs_notificado -> setAttrib('rows','5');
		$obs_notificado -> setAttrib('cols','40');
		$obs_notificado -> addFilter('StripTags');

		$notificado->addElements(array($tipo_identificacao_notificado, $documento_notificado, $nome_notificado, 
								$telefone_notificado, $cep_notificado, $endereco_notificado, $complemento_notificado, 
								$bairro_notificado, $numero_notificado, $estado_notificado, $cidade_notificado, 
								$obs_notificado));

		$notificado->setLegend('Notificado');

		$itenspedido->addSubForm($notificado, 'notificado');
		
		$SF = $itenspedido->getSubForm('notificado');
		$SF->removeDecorator('DtDdWrapper');
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