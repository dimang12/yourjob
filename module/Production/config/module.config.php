<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Production\Controller\Index' => 'Production\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
        		'production' => array(
        				'type'    => 'Literal',
        				'options' => array(
        						// Change this to something specific to your module
        						'route'    => '/products',
        						'defaults' => array(
        								// Change this value to reflect the namespace in which
        								// the controllers for your module are found
        								'__NAMESPACE__' => 'Production\Controller',
        								'controller'    => 'Index',
        								'action'        => 'index',
        						),
        				),
        				
        			
            		'may_terminate' => true,
            		'child_routes' => array(
            				// This route is a sane default when developing a module;
            				// as you solidify the routes for your module, however,
            				// you may want to remove it and replace it with more
            				// specific routes.
            				'default' => array(
            						'type'    => 'Segment',
            						'options' => array(
            								'route'    => '/[:controller[/:action]]',
            								'constraints' => array(
            										'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
            										'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
            								),
            								'defaults' => array(
            								),
            						),
            				),
            		),
            	),
//
//        		'products' => array(
//        				'type' => 'Zend\Mvc\Router\Http\Regex',
//        				'options' => array(
//        						'regex' => '/(?<alias>[a-zA-Z0-9_-]+)/(?<products>[a-zA-Z0-9_-]+)',
//        						'spec' => '/products/',
//        						'defaults' => array(
//        								'controller' => 'Production\Controller\Index',
//        								'action' => 'info',
//        						),
//        				),
//        		),
//
//        		'viewmore' => array(
//        				'type' => 'Zend\Mvc\Router\Http\Regex',
//        				'options' => array(
//        						'regex' => '/(?<alias>[a-zA-Z0-9_-]+)/(?<products>[a-zA-Z0-9_-]+)/(?<application>[a-zA-Z0-9_-]+)',
//        						'spec' => '/products/application/',
//        						'defaults' => array(
//        								'controller' => 'Production\Controller\Index',
//        								'action' => 'viewmore',
//        						),
//        				),
//        		),
//
//        		'series' => array(
//        				'type' => 'Zend\Mvc\Router\Http\Regex',
//        				'options' => array(
//        						'regex' => '/(?<alias>[a-zA-Z0-9_-]+)/(?<products>[a-zA-Z0-9_-]+)/(?<application>[a-zA-Z0-9_-]+)/(?<series>[a-zA-Z0-9_-]+)',
//        						'spec' => '/products/application/series/',
//        						'defaults' => array(
//        								'controller' => 'Production\Controller\Index',
//        								'action' => 'series',
//        						),
//        				),
//        		),
        	),
        ),
		'service_manager' => array (
				'factories' => array (
						'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory'
				)
		),
		
		'translator' => array (
				 'locale' => 'en_US',
				//'locale' => 'km_KH',
				'translation_file_patterns' => array (
						array (
								'type' => 'gettext',
								'base_dir' => __DIR__ . '/../language',
								'pattern' => '%s.mo'
						)
				)
		),
	    'view_manager' => array(
				'template_path_stack' => array(
						'Production' => __DIR__ . '/../view',
				),
		),
);
