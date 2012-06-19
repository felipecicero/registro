<?php

class Registro_Form_Titulodocumentos extends Zend_Form
{

    public function init()
    {
	
		$this->setDecorators(array( 'FormElements', 'Form'));
		
		$decorator_default = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field')));
		$decorator_check = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field checkbox')));
		$decorator_margin = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field margin')));
		$decorator_textarea = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field textarea')));
		$decorator_option = array('ViewHelper','Errors','Label',array(array('row' => 'HtmlTag'),array('class' => 'option-field')));
       
		$model_protocolo = new Protocolo();
        $protocolo = new Zend_Form_Element_Select('idProtocolo');
		$protocolo -> clearDecorators();
		$protocolo -> addDecorators($decorator_default);
		$protocolo ->setLabel('Protocolo:');
		$protocolo ->setAttrib('disabled', 'disabled');
		$protocolo ->setAttrib('class', 'half');
		foreach ($model_protocolo->findForSelect() as $prot) {
	    	$protocolo->addMultiOption($prot->idProtocolo, $this->completa(18, $prot->protocolo, "0"));
		}
		
		$model_situacao = new Situacao();
	    $situacao = new Zend_Form_Element_Select('idSituacao');
		$situacao -> clearDecorators();
		$situacao -> addDecorators($decorator_default);
		$situacao -> setLabel('Situação:');
		$situacao -> setAttrib('disabled', 'disabled');
		$situacao -> setAttrib('class', 'half');
	    foreach ($model_situacao->findForSelect() as $situa) {
	    	$situacao->addMultiOption($situa->idSituacao, $situa->descricao);
		}
		
		$validate = new Zend_Validate_Date(array('locale' => 'pt-Br'));
    	$data_registro = new Zend_Form_Element_Text('dataregistro');
		$data_registro -> clearDecorators();
		$data_registro -> addDecorators($decorator_default);
    	$data_registro -> setLabel("Data Registro:");   
		$data_registro -> setAttrib('class', 'half');
    	$data_registro -> setAttrib('maxlength', '10');
    	$data_registro -> setAttrib('onKeyDown', 'Mascara(this,mdata);');
    	$data_registro -> setAttrib('onKeyPress', 'Mascara(this,mdata);');
    	$data_registro -> setAttrib('onKeyUp', 'Mascara(this,mdata);');
    	$data_registro -> addValidator($validate);			
    	$data_registro -> setRequired(true);
		
		
		$model_tipodocumento = new Tipodocumento();
	    $tipodocumento = new Zend_Form_Element_Select('idTipodocumento');
		$tipodocumento -> clearDecorators();
		$tipodocumento -> addDecorators($decorator_default);
		$tipodocumento -> setLabel('Tipo Título:')
		$tipodocumento -> setRequired(true);	
	    foreach ($model_tipodocumento->findForSelect() as $tipo) {
	    	$tipodocumento -> addMultiOption($tipo->idTipodocumentos, $tipo->nome);
		}
		
		$emolumentos = new Zend_Form_Element_Select('emolumentos');
		$emolumentos -> clearDecorators();
		$emolumentos -> addDecorators($decorator_default);
		$emolumentos -> setLabel("Emolumento:");  
		
		$paginas = new Zend_Form_Element_Text('numeropaginas');
		$paginas -> clearDecorators();
		$paginas -> addDecorators($decorator_default);
    	$paginas -> setLabel("Número de Páginas:");   
    	$paginas -> setAttrib('maxlength', '10');		
    	$paginas -> setRequired(true);
		
		
		
    }


}

