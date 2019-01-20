<?php

namespace Pessoa;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface {

    public function getConfig()
    {
        return include __DIR__.'/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\PessoaTable::class => function($container)
                {
                    $tableGateway = $container->get(Module\PessoaTableGateway::class);
                    return new PessoaTable($tableGateway);
                },
                Model\PessoaTableGateway::class => function($container)
                {
                    $dbAdapter = $container->(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Pessoa());
                    return new TableGateway('pessoa',$dbAdapter,null,$resultSetPrototype);
                },
            ]
        ];
    }
}