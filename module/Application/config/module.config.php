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
                        'job-employer' => array(
                            'type'    => 'segment',
                            'options' => array(
                                'route'    => '/job-employer[/][:action][/:id]',
                                'constraints' => array(
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id'     => '[0-9]+',
                                ),
                                'defaults' => array(
                                    'controller' => 'Application\Controller\Seeker',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
//						'job-employer' => array (
//								'type' => 'Zend\Mvc\Router\Http\Literal',
//								'options' => array (
//										'route' => '/job-employer',
//										'defaults' => array (
//												'controller' => 'Application\Controller\Seeker',
//												'action' => 'index'
//										)
//								)
//						),
						
						'resume' => array (
								'type' => 'Segment',
								'options' => array (
										'route' => '/resume[/:action][/][:id]',
										'defaults' => array (
												'controller' => 'Application\Controller\Resume',
												'action' => 'index'
										) 
								) 
						),
						
						'education' => array (
								'type' => 'Segment',
								'options' => array (
										'route' => '/education[/:action[/:id]]',
										'defaults' => array (
												'controller' => 'Application\Controller\Education',
												'action' => 'index' 
										) 
								) 
						),

                        'home' => array (
                            'type' => 'Segment',
                            'options' => array (
                                'route' => '/home[/:action[/:id]]',
                                'defaults' => array (
                                    'controller' => 'Application\Controller\Index',
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


                    'jobdt' => array (
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array (
                            'route' => '/jobdt/',
                            'defaults' => array (
                                'controller' => 'Application\Controller\Index',
                                'action' => 'jobdt',
                                'alias' => '[a-zA-Z0-9]+'
                            )
                        )
                    ),


                        'register'=>array(
                            'type' => 'Segment',
                            'options' =>array(
                                'route' => '/register[/][:action][/:id]',
                                'constraints' => array(
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id' => '[0-9]+',
                                ),
                                'defaults'=>array(
                                    'controller' => 'Application\Controller\Register',
                                    'action' => 'index',
                                ),
                            ) ,
                        ),
                        'document-share'=>array(
                            'type' => 'Segment',
                            'options' =>array(
                                'route' => '/document-share[/][:action][/:id]',
                                'constraints' => array(),
                                'defaults'=>array(
                                    'controller' => 'Application\Controller\Share',
                                    'action' => 'index',
                                ),
                            ) ,
                        ),
                        'experience-share'=>array(
                            'type' => 'Segment',
                            'options' =>array(
                                'route' => '/experience-share[/][:action][/:id][/:type]',
                                'constraints' => array(),
                                'defaults'=>array(
                                    'controller' => 'Application\Controller\Experience',
                                    'action' => 'index',
                                ),
                            ) ,
                        ),
                        'info'=>array(
                            'type' => 'Segment',
                            'options' =>array(
                                'route' => '/info[/][:action][/:id]',
                                'constraints' => array(),
                                'defaults'=>array(
                                    'controller' => 'Application\Controller\Info',
                                    'action' => 'about',
                                ),
                            ) ,
                        ),
						// The following is a route to simplify getting started creating
						// new controllers and actions without needing to create a new
						// module. Simply drop new controllers in, and you can access them
						// using the path /application/:controller/:action
						'application' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/',
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
                        'Application\Controller\Ajax' => 'Application\Controller\AjaxController',
				        'Application\Controller\Register' => 'Application\Controller\RegisterController',
				        'Application\Controller\Share' => 'Application\Controller\ShareController',
				        'Application\Controller\Info' => 'Application\Controller\InfoController',
				        'Application\Controller\Experience' => 'Application\Controller\ExperienceController',
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
