<?php
namespace Production;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Production\Model\ProductTable;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

	public function getServiceConfig() {
	        return array(
	            'factories' => array(
	            		'Production\Model\ProductTable' => function($sm) {
	            			$tableGateway = $sm->get('ProductTableGateway');
	            			$table = new ProductTable($tableGateway);
	            			return $table;
	            		},
	            		'ProductTableGateway' => function ($sm) {
	            			$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
	            			$resultSetPrototype = new ResultSet();
	            			return new TableGateway('categories', $dbAdapter, null, $resultSetPrototype);
	            		},
	            ),
	        );
	
	 }
    
    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
}
