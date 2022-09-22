<?php

    namespace Empresa;

use Empresa\Controller\EmpresaController;
use Empresa\Model\EmpresaTable;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

    class Module implements ConfigProviderInterface {
        
        public function getConfig() 
        {
            return include __DIR__ . '/../config/module.config.php';
        }

        public function getServiceConfig()
        {
            return [
                'factories' => [
                    Model\EmpresaTable::class => function($container)
                    {
                        $tableGateway = $container->get(Model\EmpresaTableGateway::class);
                        return new EmpresaTable($tableGateway);
                    },
                    Model\EmpresaTableGateway::class => function($container)
                    {
                        $dbAdapter = $container->get(AdapterInterface::class);
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Model\Empresa());
                        return new TableGateway('company', $dbAdapter, null, $resultSetPrototype);
                    }
                ]
            ];
        }

        public function getControllerConfig()
        {
            return [
                'factories' => [
                    EmpresaController::class => function($container){
                        $tableGateway = $container->get(Model\EmpresaTable::class);
                        return new EmpresaController($tableGateway);
                    }
                ],
            ];
        }
    }
