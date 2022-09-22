<?php

namespace Empresa\Form;

use Zend\Form\Form;

class EmpresaForm extends Form
{
    public function __construct()
    {
        parent::__construct('empresa', []);

        $this->add(new \Zend\Form\Element\Hidden('id'));
        $this->add(new \Zend\Form\Element\Text('name', ["label" => "Nome"]));
        $this->add(new \Zend\Form\Element\Text('cnpj', ["label" => "CNPJ"]));
        $this->add(new \Zend\Form\Element\Text('address', ["label" => "Endereço"]));

        $submit = new \Zend\Form\Element\Submit('submit');
        $submit->setAttributes(['value' => 'Salvar', 'id' => 'submitbutton']);
        $this->add($submit);
    }
}
