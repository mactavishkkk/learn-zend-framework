<?php

namespace Empresa\Model;

use Zend\Stdlib\ArraySerializableInterface;

class Empresa implements ArraySerializableInterface
{

    private $id;
    private $name;
    private $cnpj;
    private $address;

    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->cnpj = !empty($data['cnpj']) ? $data['cnpj'] : null;
        $this->address = !empty($data['address']) ? $data['address'] : null;
    }

    public function getArrayCopy(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cnpj' => $this->cnpj,
            'address' => $this->address,
        ];
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCnpj()
    {
        return $this->cnpj;
    }
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }
}
