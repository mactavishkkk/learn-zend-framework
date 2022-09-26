<?php

namespace ProprietarioTest\Model;

use Proprietario\Model\ProprietarioTable;
use Proprietario\Model\Proprietario;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\TableGateway\TableGatewayInterface;

class ProprietarioTableTest extends TestCase
{
    protected function setUp(): void
    {
        $this->tableGateway = $this->prophesize(TableGatewayInterface::class);
        $this->proprietarioTable = new ProprietarioTable($this->tableGateway->reveal());
    }

    public function testFetchAllReturnsAllProprietarios()
    {
        $resultSet = $this->prophesize(ResultSetInterface::class)->reveal();
        $this->tableGateway->select()->willReturn($resultSet);

        $this->assertSame($resultSet, $this->proprietarioTable->fetchAll());
    }

    public function testCandDeleteAnProprietarioByItsId()
    {
        $this->tableGateway->delete(['id' => 123])->shouldBeCalled();
        $this->proprietarioTable->deleteProprietario(123);
    }

    public function testSaveProprietarioWillInsertNewProprietarioIfTheyDontAlreadyHaveAnId()
    {
        $proprietarioData = [
            'name' => 'fulano',
            'cpf' => '12345678901',
            'phone' => '92948574832',
            'email' => 'fulano@gmail.com'
        ];

        $proprietario = new Proprietario();
        $proprietario->exchangeArray($proprietarioData);

        $this->tableGateway->insert($proprietarioData)->shouldBeCalled();
        $this->proprietarioTable->saveProprietario($proprietario);
    }

    public function testSaveProprietarioWillUpdateExistingAlbumsIfTheyAlreadyHaveAnId()
    {
        $data = [
            'id'     => 123,
            'name' => 'Isaías Leite',
            'cpf'  => '703948273849',
            'phone' => '92984756482',
            'email' => 'isaias@gmail.com'
        ];
        $proprietario = new Proprietario();
        $proprietario->exchangeArray($data);

        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn($proprietario);

        $this->tableGateway
            ->select(['id' => 123])
            ->willReturn($resultSet->reveal());
        $this->tableGateway
            ->update(
                array_filter($data, function ($key) {
                    return in_array($key, ['name', 'cpf', 'phone', 'email']);
                }, ARRAY_FILTER_USE_KEY),
                ['id' => 123]
            )->shouldBeCalled();

        $this->proprietarioTable->saveProprietario($proprietario);
    }

    public function testExceptionIsThrownWhenGettingNonExistentProprietario()
    {
        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn(null);

        $this->tableGateway
            ->select(['id' => 123])
            ->willReturn($resultSet->reveal());

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Could not find row with identifier 123');
        $this->proprietarioTable->getProprietario(123);
    }
}
