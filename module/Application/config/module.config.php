<?php
return array (
		'router' => array (
				'routes' => array (
						'home' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/',
										'defaults' => array (
												'controller' => 'Application\Controller\Index',
												'action' => 'index' 
										) 
								) 
						),
						
						'job-seeker' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/job-seeker',
										'defaults' => array (
												'controller' => 'Application\Controller\Seeker',
												'action' => 'index' 
										) 
								) 
						),
						
						'resume' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/resume',
										'defaults' => array (
												'controller' => 'Application\Controller\Resume',
												'action' => 'index' 
										) 
								) 
						),
						
						'education' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/education',
										'defaults' => array (
												'controller' => 'Application\Controller\Education',
												'action' => 'index' 
										) 
								) 
						),
						
						'beyond-living' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/beyond-living',
										'defaults' => array (
												'controller' => 'Application\Controller\beyondliving',
												'action' => 'index' 
										) 
								) 
						),
						
						'en' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/en',
										'defaults' => array (
												'controller' => 'Application\Controller\Index',
												'action' => 'en' 
										) 
								) 
						),
						'kh' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/kh',
										'defaults' => array (
												'controller' => 'Application\Controller\Index',
												'action' => 'kh' 
										) 
								) 
						),
						'about' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/aboutus',
										'defaults' => array (
												'controller' => 'Application\Controller\About',
												'action' => 'index' 
										) 
								) 
						),
						'promotion' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/promotion',
										'defaults' => array (
												'controller' => 'Application\Controller\Promotion',
												'action' => 'index' 
										) 
								) 
						),
						
						'showcases' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/showcases',
										'defaults' => array (
												'controller' => 'Application\Controller\Showcase',
												'action' => 'index' 
										) 
								) 
						),
						
						'contact' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/contact',
										'defaults' => array (
												'controller' => 'Application\Controller\Contact',
												'action' => 'index' 
										) 
								) 
						),
						
						'support' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/support',
										'defaults' => array (
												'controller' => 'Application\Controller\Support',
												'action' => 'index' 
										) 
								) 
						),

                        'category' => array (
                            'type' => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array (
                                'route' => '/category/',
                                'defaults' => array (
                                    'controller' => 'Application\Controller\Index',
                                    'action' => 'category',
                                    'alias' => '[a-zA-Z0-9]+'
                                )
                            )
                        ),

						'scene' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/scene',
										'defaults' => array (
												'controller' => 'Application\Controller\Showcase',
												'action' => 'scene' 
										) 
								) 
						),
						// The following is a route to simplify getting started creating
						// new controllers and actions without needing to create a new
						// module. Simply drop new controllers in, and you can access them
						// using the path /application/:controller/:action
						'application' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/application',
										'defaults' => array (
												'__NAMESPACE__' => 'Application\Controller',
												'controller' => 'Index',
												'action' => 'index' 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'default' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/[:controller[/:action]]',
														'constraints' => array (
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action' => '[a-zA-Z][a-zA-Z0-9_-]*' 
														),
														'defaults' => array () 
												) 
										) 
								) 
						) 
				) 
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
		'controllers' => array (
				'invokables' => array (
						'Application\Controller\Index' => 'Application\Controller\IndexController',
						'Application\Controller\About' => 'Application\Controller\AboutController',
						'Application\Controller\Seeker' => 'Application\Controller\SeekerController',
                        'Application\Controller\Resume' => 'Application\Controller\ResumeController',
                        'Application\Controller\Education' => 'Application\Controller\EducationController',
				) 
		),
		'view_manager' => array (
				'display_not_found_reason' => true,
				'display_exceptions' => true,
				'doctype' => 'HTML5',
				'not_found_template' => 'error/404',
				'exception_template' => 'error/index',
				'template_map' => array (
						'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
						'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
						'error/404' => __DIR__ . '/../view/error/404.phtml',
						'error/index' => __DIR__ . '/../view/error/index.phtml' 
				),
				'template_path_stack' => array (
						__DIR__ . '/../view' 
				) 
		) 
);
