<?php

namespace Empresa\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class EmpresaTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getAll()
    {
        return $this->tableGateway->select();
    }

    public function getEmpresa($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();

        if (!$row) {
            throw new RuntimeException(sprintf('Não foi encontrado o id %d', $id));
        }

        return $row;
    }

    public function salvarEmpresa(Empresa $empresa)
    {
        $data = [
            'name' => $empresa->getName(),
            'cnpj' => $empresa->getCnpj(),
            'address' => $empresa->getAddress()
        ];

        $id = (int) $empresa->getId();
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deletarEmpresa($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
