<?php

class Admin_Form_Selo extends Zend_Form
{
public function init()
    {
		$this->setDecorators(array( 'FormElements', 'Form')); 
		$decorator_default = array('ViewHelper','Errors','Description','HtmlTag','Label',array(array('row' => 'HtmlTag'),array('tag' => 'div', 'class' => 'field')));
		
        //$this->setName('login');

		$idSelos = new Zend_Form_Element_Hidden('idSelos');
		$idSelos -> clearDecorators();
		$idSelos -> addDecorators($decorator_default);
              
		$tipo = new Zend_Form_Element_Text('tipo');
		$tipo -> clearDecorators();
		$tipo -> addDecorators($decorator_default);
        $tipo -> setLabel('Tipo:')
              -> setRequired(true);
              
    	$serie = new Zend_Form_Element_Text('serie');
		$serie -> clearDecorators();
		$serie -> addDecorators($decorator_default);
        $serie -> setLabel('Série:');
        $serie -> setRequired(true);
        $serie -> addValidator('Db_NoRecordExists', false,
						 array('table' => 'car_situacao',
							   'field' => 'codigo' ));
    	
        $inicio = new Zend_Form_Element_Text('numeroinicial');
		$inicio -> clearDecorators();
		$inicio -> addDecorators($decorator_default);
        $inicio -> setLabel('Nº Inicial:');
        $inicio -> setRequired(true);
                
        $final = new Zend_Form_Element_Text('numerofinal');
		$final -> clearDecorators();
		$final -> addDecorators($decorator_default);
        $final -> setLabel('Nº Final:');
        $final -> setRequired(true);
                
        $notafiscal = new Zend_Form_Element_Text('notafiscal');
		$notafiscal -> clearDecorators();
		$notafiscal -> addDecorators($decorator_default);
        $notafiscal -> setLabel('Nota Fiscal:');
        
        $data_nota = new Zend_Form_Element_Text('data_nota');
		$data_nota -> clearDecorators();
		$data_nota -> addDecorators($decorator_default);
        $data_nota -> setLabel('Data da Nota Fiscal:');
        
 
        $submit = new Zend_Form_Element_Submit('Salvar');
        $submit -> setAttrib('id', 'submitbutton');
		$submit -> clearDecorators();
		$submit -> setDecorators(array('ViewHelper'));
 
        $this->addElements(array($idSelos, $tipo, $serie, $inicio, $final, $notafiscal, $data_nota, $submit));    
    }
    
	public function setAsEditForm(Zend_Db_Table_Row $row){
        $this->populate($row->toArray());
        //$this->setAction(sprintf('digitalizaraceite/idProtesto/%d', $row->idProtesto));

        $this->getElement('idSelos');
        $this->getElement('tipo');
        $this->getElement('serie');
        $this->getElement('inicio');
        $this->getElement('final');
        $this->getElement('notafiscal');
        $this->getElement('data_nota');

        return $this;
    }
}

