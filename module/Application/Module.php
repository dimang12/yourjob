<?php

namespace Application;

use Application\View\Helper\getCategories;
use Application\View\Helper\getLocations;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\View\Helper\Language;
use Zend\Session\Container;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\BeyondTable;
use Zend\Authentication\AuthenticationService, Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Http\Header\SetCookie;
use Application\Model\ShowcaseTable;
use Application\View\Helper\getProduct;
use Application\View\Helper\getBeyondLiving;

class Module {
	public function onBootstrap($e) {
		$translator = $e->getApplication ()->getServiceManager ()->get ( 'translator' );
		$eventManager = $e->getApplication ()->getEventManager ();
		$moduleRouteListener = new ModuleRouteListener ();
		$moduleRouteListener->attach ( $eventManager );
		
		$headerCookie = $e->getRequest ()->getHeaders ()->get ( 'Cookie' );
		
		if (isset ( $headerCookie->lang )) {
			$translator->setLocale ( $headerCookie->lang );
		} else {
			$cookie = new SetCookie ( 'lang', 'en_US', time () + 60 * 60 * 24 * 30 );
			$response = $e->getResponse ()->getHeaders ();
			$response->addHeader ( $cookie );
		}
	}
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\StandardAutoloader' => array (
						'namespaces' => array (
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__ 
						) 
				) 
		);
	}
	public function getViewHelperConfig() {
		return array (
				'factories' => array (
						'language' => function ($langParam) {
							$serviceLocator = $langParam->getServiceLocator ();
							$viewHelp = new Language ();
							$viewHelp->setServiceLocator ( $serviceLocator );
							return $viewHelp;
						},
						'getProduct' => function ($getProduct) {
							$serviceLocator = $getProduct->getServiceLocator();
							$product = new getProduct();
							$product->setServiceLocator($serviceLocator);
							return $product;
						},
						'getBeyond' => function ($getBeyond) {
							$serviceLocator = $getBeyond->getServiceLocator();
							$b = new getBeyondLiving();
							$b->setServiceLocator($serviceLocator);
							return $b;
						},
                        'getCategories' => function ($sm) {
                            $adapter = $sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                            $cateHelper =  new getCategories($adapter);
                            $cateHelper->setAdapter($adapter);
                            return $cateHelper;
                        },
                        'getLocations' => function ($sm){
                            return new getLocations($sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
                        }
				)
		
		// other here!
				);
	}
	public function getServiceConfig() {
		return array (
				'factories' => array (
						'Application\Model\BeyondTable' => function ($sm) {
							$tableGateway = $sm->get ( 'BeyondTableGateway' );
							$table = new BeyondTable ( $tableGateway );
							return $table;
						},
						'BeyondTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							return new TableGateway ( 'living', $dbAdapter, null, $resultSetPrototype );
						},
						'Application\Model\ShowcaseTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ShowcaseTableGateway' );
							$table = new ShowcaseTable($tableGateway);
		            			return $table;
		            		},
		            		'ShowcaseTableGateway' => function ($sm) {
		            			$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		            			$resultSetPrototype = new ResultSet();
		            			return new TableGateway('showcase', $dbAdapter, null, $resultSetPrototype);
		            		},
                            'CategoriesTableGateway' => function($sm){
                                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                                    $resultSetPrototype = new ResultSet();
                                    return new TableGateway('categories', $dbAdapter, null, $resultSetPrototype);
                                }
		            ),
		        );
		
		 }
    
   
}
