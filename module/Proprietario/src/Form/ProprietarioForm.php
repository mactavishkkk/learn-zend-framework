<?php

namespace Proprietario\Form;

use Zend\Form\Form;

class ProprietarioForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('proprietario');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Name',
            ],
        ]);

        $this->add([
            'name' => 'cpf',
            'type' => 'text',
            'options' => [
                'label' => 'CPF',
            ],
        ]);

        $this->add([
            'name' => 'phone',
            'type' => 'text',
            'options' => [
                'label' => 'Telefone',
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => 'text',
            'options' => [
                'label' => 'E-mail',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id' => 'submitbutton',
            ],
        ]);
    }
}
