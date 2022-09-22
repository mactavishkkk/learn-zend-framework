<?php

namespace ProprietarioTest\Controller;

use Proprietario\Controller\ProprietarioController;
use Proprietario\Model\Proprietario;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

use Proprietario\Model\ProprietarioTable;
use Zend\ServiceManager\ServiceManager;

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
        $services->setAllowOverride(true).
        $services->setService('config', $config);
        $services->setAllowOverride(false);
    }

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
}
