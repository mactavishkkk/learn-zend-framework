<?php

namespace ProprietarioTest\Controller;

use Proprietario\Controller\ProprietarioController;
use Proprietario\Model\Proprietario;

use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

use Proprietario\Model\ProprietarioTable;
use Zend\ServiceManager\ServiceManager;

use Prophecy\Argument;

class ProprietarioControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;
    protected $proprietarioTable;

    public function setUp(): void
    {
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));
        parent::setUp();

        $this->configureServiceManager($this->getApplicationServiceLocator());

        $services = $this->getApplicationServiceLocator();
        $config = $services->get('config');
        unset($config['db']);
        $services->setAllowOverride(true) .
            $services->setService('config', $config);
        $services->setAllowOverride(false);
    }

    // Test: Access a methods, url and controller

    public function testIndexActionCanBeAccessed()
    {
        $this->proprietarioTable->fetchAll()->willReturn([]);

        $this->dispatch('/proprietario');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Proprietario');
        $this->assertControllerName(ProprietarioController::class);
        $this->assertControllerClass('ProprietarioController');
        $this->assertMatchedRouteName('proprietario');
    }

    // Config: Connection with database for test the get services 

    protected function configureServiceManager(ServiceManager $services)
    {
        $services->setAllowOverride(true);

        $services->setService('config', $this->updateConfig($services->get('config')));
        $services->setService(ProprietarioTable::class, $this->mockProprietarioTable()->reveal());

        $services->setAllowOverride(false);
    }

    protected function updateConfig($config)
    {
        $config['db'] = [];
        return $config;
    }

    protected function mockProprietarioTable()
    {
        $this->proprietarioTable = $this->prophesize(ProprietarioTable::class);
        return $this->proprietarioTable;
    }

    //Test: Methods actions

    public function testAddActionRedirectsAfterValidPost()
    {
        $this->proprietarioTable->saveProprietario(Argument::type(Proprietario::class))->shouldBeCalled();

        $postData = [
            'name' => 'Fulano',
            'cpf' => '94857482912',
            'phone' => '49287482948',
            'email' => 'fulano@gmail.com',
            'id' => ''
        ];

        $this->dispatch('/proprietario/add', 'POST', $postData);
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/proprietario');
    }

    public function testEditActionRedirectsAfterValidPost()
    {
        $id = 1;
        $this->proprietarioTable->getProprietario($id)->willReturn(new Proprietario());
        $this->proprietarioTable->saveProprietario(Argument::type(Proprietario::class))->shouldBeCalled();

        $postData = [
            'name' => 'Fulano',
            'cpf' => '94857482912',
            'phone' => '49287482948',
            'email' => 'fulano@gmail.com',
            'id' => ''
        ];

        $this->dispatch('/proprietario/edit/1', 'POST', $postData);
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/proprietario');
    }

    // public function testDeleteActionRedirectsAfterValidPost()
    // {
    //     $id = 1;
    //     $this->proprietarioTable->getProprietario($id)->willReturn(new Proprietario());
    //     $this->proprietarioTable->deleteProprietario(Argument::type(Proprietario::class))->shouldBeCalled();

    //     $postData = [
    //         'name' => 'Fulano',
    //         'cpf' => '94857482912',
    //         'phone' => '49287482948',
    //         'email' => 'fulano@gmail.com',
    //         'id' => ''
    //     ];

    //     $this->dispatch('/proprietario/delete/1', 'POST', $postData);
    //     $this->assertResponseStatusCode(302);
    //     $this->assertRedirectTo('/proprietario');
    // }
}
