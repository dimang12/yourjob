<?php
namespace Admin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use	Zend\Authentication\AuthenticationService,
Zend\Authentication\Storage\Session as SessionStorage;
use Admin\Model\GlobalModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements AutoloaderProviderInterface
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

    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'auth_login' => function ($sm) {
    						$authLogin = new AuthenticationService(new SessionStorage('users'));
    						return $authLogin;
    					},
    					'Admin\Model\GlobalModel' => function($sm) {
    						$tableGateway = $sm->get('table');
    						$table = new GlobalModel($tableGateway);
    						return $table;
    					},
    					'table' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						return new TableGateway('categories', $dbAdapter, null, $resultSetPrototype);
    					},
    			)
    	);
    }
    public function getViewHelperConfig()   {
    	return array(
    			'factories' => array(    					
    					'getParams' => function($helperPluginManager){
    						$serverLocatior = $helperPluginManager->getServiceLocator();
    						$viewHelper = new View\GetParams();
    						$viewHelper->setServiceLocator($serverLocatior);
    						return $viewHelper;
    					},
    			),
    	);
    }
    public function onBootstrap($e)
    {
    	$e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
    		$controller      = $e->getTarget();
    		$controllerClass = get_class($controller);
    		$moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
    		if ('Admin' === $moduleNamespace ) {
    			$controller->layout('layout/admin');
    		}
    	}, 100);
    }
}
