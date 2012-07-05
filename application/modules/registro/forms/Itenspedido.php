<?php

class Registro_Form_Itenspedido extends Zend_Form
{

    public function init()
    {
       
		$this->setDecorators(array( 'FormElements', 'Form')); 
		$decorator_default = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field')));
		$decorator_check = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field checkbox')));
		$decorator_margin = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field margin')));
		$decorator_textarea = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field textarea')));
		$decorator_option = array('ViewHelper','Errors','Label',array(array('row' => 'HtmlTag'),array('class' => 'option-field')));
		
	    $pedido = new Zend_Form_Element_Text('pedido');
		$pedido -> clearDecorators();
		$pedido -> addDecorators($decorator_default);
		$pedido -> setLabel('Pedido:');
		$pedido -> setAttrib('disabled', 'disabled');
		$pedido -> setAttrib('class', 'half');
		
		$item_pedido = new Zend_Form_Element_Text('item_pedido');
		$item_pedido -> clearDecorators();
		$item_pedido -> addDecorators($decorator_default);
		$item_pedido -> setLabel('Protocolo:');
		$item_pedido -> setAttrib('disabled', 'disabled');
		$item_pedido -> setAttrib('class', 'half');
	    
		/*
		$model_registro = new Registro();
	    $registro = new Zend_Form_Element_Select('idRegistro');
		$registro -> clearDecorators();
		$registro -> addDecorators($decorator_default);
		$registro -> setLabel('Registro:');
		$registro -> setAttrib('disabled', 'disabled');
		$registro -> setAttrib('class', 'half');
	    foreach ($model_registro->findForSelect() as $regi) {
	    	$registro -> addMultiOption($regi->idRegistro, $this->completa(10, $regi->registro, "0"));
		}
		*/
		$livro = new Zend_Form_Element_Select('livro');
		$livro -> clearDecorators();
		$livro -> addDecorators($decorator_default);
    	$livro -> setLabel("Livro");
		$livro -> setAttrib('class', 'half');
    	$livro -> setRequired(true);
		$livro -> addMultiOption(1,"Livro A");
		$livro -> addMultiOption(2,"Livro B");
		$livro -> addMultiOption(3,"Livro C");
		
		$model_situacao = new Situacoes();
	    $pedido_situacao = new Zend_Form_Element_Text('pedido_situacao');
		$pedido_situacao -> clearDecorators();
		$pedido_situacao -> addDecorators($decorator_default);
		$pedido_situacao -> setLabel('Situação:');
		$pedido_situacao -> setAttrib('disabled', 'disabled');
		$pedido_situacao -> setAttrib('class', 'half');
	    
		
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
    	$data_situacao -> setAttrib('disabled', 'disabled');
    	$data_situacao -> addValidator($validate);
    	$data_situacao -> addValidator($validator_date);
    	$data_situacao -> setRequired(true);
    	$data_situacao -> setValue(date('dmY'));
		
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
		$valor = $model_custa->getCustaByName('taxa_judiciaria');
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
		
		$submit = new Zend_Form_Element_Submit('Salvar');
        $submit -> setAttrib('id', 'submitbutton-import');
		$submit -> clearDecorators();
		$submit -> setDecorators(array('ViewHelper'));
		
		$submit_temp = new Zend_Form_Element_Submit('adicionar');
		$submit_temp -> setAttrib('id', 'submitbutton-itempedido');
		$submit_temp -> clearDecorators();
		$submit_temp -> setDecorators(array('ViewHelper'));
		
		$submit_final = new Zend_Form_Element_Submit('submitfinal');
		$submit_final -> setAttrib('id', 'submitbutton-itempedido');
		$submit_final -> clearDecorators();
		$submit_final -> setDecorators(array('ViewHelper'));
		
		$this->addElements(array($pedido, $item_pedido, $livro, $pedido_situacao, $data_situacao, 
								$tipodocumentos, $tipoemolumento, $numeropaginas, $numerovias, $numeropessoas, 
								$valor_documento, $emolumento, $valor_correio, $outras_despesas, $taxa_judiciaria, 
								$funcivil, $total_custas, $submit, $submit_temp, $submit_final));
			
			$pessoa = new Zend_Form_SubForm();
			
			$tipo_identificacao_citado = new Zend_Form_Element_Radio('tipo_identificacao_citado');
			$tipo_identificacao_citado -> clearDecorators();
			$tipo_identificacao_citado -> addDecorators($decorator_default);
			$tipo_identificacao_citado -> setLabel('Tipo do documento:');
			$tipo_identificacao_citado -> addMultiOptions(array(
														'1' => 'CNPJ',
														'2' => 'CPF'));
			$tipo_identificacao_citado -> setSeparator('');
			$tipo_identificacao_citado -> setValue('1');
			
			$documento_citado = new Zend_Form_Element_Text('documento_citado');
			$documento_citado -> clearDecorators();
			$documento_citado -> addDecorators($decorator_default);
			$documento_citado -> setLabel("Documento:");
			$documento_citado -> setAttrib('class', 'half');
					  
			$nome_citado = new Zend_Form_Element_Text('nome_citado');
			$nome_citado -> clearDecorators();
			$nome_citado -> addDecorators($decorator_default);
			$nome_citado -> setLabel("Nome:");
			$nome_citado -> setAttrib('class', 'half');
				 
			$cep_citado = new Zend_Form_Element_Text('cep_citado');
			$cep_citado -> clearDecorators();
			$cep_citado -> addDecorators($decorator_default);
			$cep_citado -> setLabel("CEP:");
			$cep_citado -> setAttrib('class', 'half');
			
			$endereco_citado = new Zend_Form_Element_Text('endereco_citado');
			$endereco_citado -> clearDecorators();
			$endereco_citado -> addDecorators($decorator_default);
			$endereco_citado -> setLabel("Endereço:");
			$endereco_citado -> setAttrib('class', 'half');
							
							
			$telefone_citado = new Zend_Form_Element_Text('telefone_citado');
			$telefone_citado -> clearDecorators();
			$telefone_citado -> addDecorators($decorator_default);
			$telefone_citado -> setLabel("Telefone:");
			$telefone_citado -> setAttrib('size', '14');
			

			$complemento_citado = new Zend_Form_Element_Text('complemento_citado');
			$complemento_citado -> clearDecorators();
			$complemento_citado -> addDecorators($decorator_default);
			$complemento_citado -> setLabel("Complemento:");
			$complemento_citado -> setAttrib('class', 'half');
				 
			$bairro_citado = new Zend_Form_Element_Text('bairro_citado');
			$bairro_citado -> clearDecorators();
			$bairro_citado -> addDecorators($decorator_default);
			$bairro_citado -> setLabel("Bairro:");
			$bairro_citado -> setAttrib('class', 'half');
				 
			$numero_citado = new Zend_Form_Element_Text('numero_citado');
			$numero_citado -> clearDecorators();
			$numero_citado -> addDecorators($decorator_default);
			$numero_citado -> setLabel("Número:");
			$numero_citado -> setAttrib('class', 'half');
			
			$model_estado = new Estado();
			$estado_citado = new Zend_Form_Element_Select('estado_citado');
			$estado_citado -> clearDecorators();
			$estado_citado -> addDecorators($decorator_default);
			$estado_citado -> setLabel('UF:');
			$estado_citado -> setAttrib('class', 'half');
			$estado_citado -> setRequired(true);
			$estado_citado -> addMultiOption('0', 'Selecione o Estado');		
			foreach ($model_estado->findForSelect() as $uf) {
				$estado_citado -> addMultiOption($uf->idEstado, $uf->sigla);
			} 
										 
			$cidade_citado = new Zend_Form_Element_Select('cidade_citado');
			$cidade_citado -> clearDecorators();
			$cidade_citado -> addDecorators($decorator_default);
			$cidade_citado -> setLabel("Cidade:");
			$cidade_citado -> setAttrib('class', 'half');
			$cidade_citado -> setRegisterInArrayValidator(false);
			$cidade_citado -> setRequired(true);
			
			$notificar = new Zend_Form_Element_Checkbox('notificar');
			$notificar -> setLabel("Notificar pessoa?");
			$notificar -> clearDecorators();
			$notificar -> addDecorators($decorator_check);
			$notificar -> setAttrib('size', '10');
			
			$obs_citado = new Zend_Form_Element_Textarea('obs_citado');
			$obs_citado -> clearDecorators();
			$obs_citado -> addDecorators($decorator_textarea);
			$obs_citado -> setLabel('Observações:');
			$obs_citado -> setAttrib('rows','5');
			$obs_citado -> setAttrib('cols','40');
			$obs_citado -> addFilter('StripTags');
			
			$pessoa->setLegend('Pessoas Citadas');
			
			$pessoa->addElements(array($tipo_identificacao_citado, $documento_citado, $nome_citado, $cep_citado, $endereco_citado, $telefone_citado, $complemento_citado, $bairro_citado, $numero_citado, $estado_citado, $cidade_citado, $obs_citado, $notificar));
		
		$this->addSubForm($pessoa, 'Pessoa');
		
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

