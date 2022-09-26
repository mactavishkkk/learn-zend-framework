<?php

namespace ProprietarioTest\Model;

use Proprietario\Model\Proprietario;
use PHPUnit\Framework\TestCase;

class ProprietarioTest extends TestCase
{
    public function testInitialProprietarioValuesAreNull()
    {
        $proprietario = new Proprietario();

        $this->assertNull($proprietario->name, '"name" should be null by default');
        $this->assertNull($proprietario->cpf, '"cpf" should be null by default');
        $this->assertNull($proprietario->phone, '"phone" should be null by default');
        $this->assertNull($proprietario->email, '"email" should be null by default');
        $this->assertNull($proprietario->id, '"id" should be null by default');
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $proprietario = new Proprietario();
        $data = [
            'name' => 'some name',
            'cpf' => 'some cpf',
            'phone' => 'some phone',
            'email' => 'some email',
            'id' => 321,
        ];

        $proprietario->exchangeArray($data);

        $this->assertSame(
            $data['name'],
            $proprietario->name,
            '"name" was not set correctly'
        );

        $this->assertSame(
            $data['cpf'],
            $proprietario->cpf,
            '"cpf" was not set correctly'
        );

        $this->assertSame(
            $data['phone'],
            $proprietario->phone,
            '"phone" was not set correctly'
        );

        $this->assertSame(
            $data['email'],
            $proprietario->email,
            '"email" was not set correctly'
        );

        $this->assertSame(
            $data['id'],
            $proprietario->id,
            '"id" was not set correctly'
        );
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $proprietario = new Proprietario();
        
        $proprietario->exchangeArray([
            'name' => 'some name',
            'cpf' => 'some cpf',
            'phone' => 'some phone',
            'email' => 'some email',
            'id' => 321,
        ]);

        $proprietario->exchangeArray([]);

        $this->assertNull($proprietario->name, '"name" should be null by default');
        $this->assertNull($proprietario->cpf, '"cpf" should be null by default');
        $this->assertNull($proprietario->phone, '"phone" should be null by default');
        $this->assertNull($proprietario->email, '"email" should be null by default');
        $this->assertNull($proprietario->id, '"id" should be null by default');
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
        $proprietario = new Proprietario();
        
        $data =[
            'name' => 'some name',
            'cpf' => 'some cpf',
            'phone' => 'some phone',
            'email' => 'some email',
            'id' => 321,
        ];

        $proprietario->exchangeArray($data);
        $copyArray = $proprietario->getArrayCopy();

        $this->assertSame($data['name'], $copyArray['name'], '"name" was not set correctly');
        $this->assertSame($data['cpf'], $copyArray['cpf'], '"cpf" was not set correctly');
        $this->assertSame($data['phone'], $copyArray['phone'], '"phone" was not set correctly');
        $this->assertSame($data['email'], $copyArray['email'], '"email" was not set correctly');
        $this->assertSame($data['id'], $copyArray['id'], '"id" was not set correctly');
    }

    public function testInputFiltersAreSetCorrectly()
    {
        $proprietario = new Proprietario();

        $inputFilter = $proprietario->getInputFilter();

        $this->assertSame(5, $inputFilter->count());
        $this->assertTrue($inputFilter->has('name'));
        $this->assertTrue($inputFilter->has('cpf'));
        $this->assertTrue($inputFilter->has('phone'));
        $this->assertTrue($inputFilter->has('email'));
        $this->assertTrue($inputFilter->has('id'));
    }
}
