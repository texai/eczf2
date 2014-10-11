<?php

namespace Application\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Filter\Word\CamelCaseToUnderscore;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractServiceFactory implements AbstractFactoryInterface
{
    // Admin\Model\ProductoTable
    // Admin\Model\UsurioTable
    // Portal\Model\UsurioTable
    protected $regex = "/^(?P<module>Admin|Portal|RealTime)\\\\Model\\\\(?P<model>[A-Z][a-zA-Z]*)Table$/";
    protected $dbadapterServiceName = 'dbadapter';
    protected $prefixEntities = 'Application\\Model\\Entity\\';
    protected $filter;

    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return preg_match($this->regex, $requestedName);
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (preg_match($this->regex, $requestedName, $matches)) {
            $module = $matches['module'];
            $model  = $matches['model'];
            $adapter = $serviceLocator->get($this->dbadapterServiceName);
            $rsPrototype = new ResultSet();
            $entityClass = $this->prefixEntities.$model;
            $rsPrototype->setArrayObjectPrototype(new $entityClass());
            $tableName = $this->modelNameToTableName($model);
            $tableGateway = new TableGateway($tableName, $adapter, null, $rsPrototype);
            $tableClass = $module.'\\Model\\'.$model.'Table';

            return new $tableClass($tableGateway);
        }
    }

    protected function modelNameToTableName($model)
    {
        if (is_null($this->filter)) {
            $this->filter = new CamelCaseToUnderscore();
        }

        return strtolower($this->filter->filter($model));
    }

}
