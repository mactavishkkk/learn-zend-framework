<?php

namespace Proprietario\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ProprietarioTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated = false)
    {
        if($paginated) {
            return $this->fetchPaginatedResults();
        }
        return $this->tableGateway->select();
    }

    private function fetchPaginatedResults()
    {
        $select = new Select($this->tableGateway->getTable());

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Proprietario());

        $paginatorAdapter = new DbSelect(
            $select, $this->tableGateway->getAdapter(), $resultSetPrototype
        );

        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }

    public function getProprietario($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        
        return $row;
    }

    public function saveProprietario(Proprietario $proprietario)
    {
        $data = [
            'name' => $proprietario->name,
            'cpf' => $proprietario->cpf,
            'phone' => $proprietario->phone,
            'email' => $proprietario->email
        ];

        $id = (int) $proprietario->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
        }

        try {
            $this->getProprietario($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf('Não foi possível encontrar o id: %d', $id));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteProprietario($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
