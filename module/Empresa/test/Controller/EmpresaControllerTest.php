<?php

namespace EmpresaTest\Controller;

use Empresa\Controller\EmpresaController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class EmpresaControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    public function setUp(): void
    {
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/empresa');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Empresa');
        $this->assertControllerName(EmpresaController::class);
        $this->assertControllerClass('EmpresaController');
        $this->assertMatchedRouteName('empresa');
    }
}