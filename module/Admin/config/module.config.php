<?php
return array (
		'controllers' => array (
				'invokables' => array (
						'Admin\Controller\Login' => 'Admin\Controller\LoginController',
						'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
						'Admin\Controller\Beyond' => 'Admin\Controller\BeyondController',
						'Admin\Controller\Showcase' => 'Admin\Controller\ShowcaseController',
						'Admin\Controller\Category' => 'Admin\Controller\CategoryController',
						'Admin\Controller\Production' => 'Admin\Controller\ProductionController',
						'Admin\Controller\Slide' => 'Admin\Controller\SlideController',
                        'Admin\Controller\Job' => 'Admin\Controller\JobController',
                        'Admin\Controller\Feature' => 'Admin\Controller\FeatureController',
                        'Admin\Controller\Employer' => 'Admin\Controller\EmployerController',
                        'Admin\Controller\Seeker' => 'Admin\Controller\SeekerController',
                        'Admin\Controller\Advertisement' => 'Admin\Controller\AdvertisementController',
                        'Admin\Controller\Education' => 'Admin\Controller\EducationController',
                        'Admin\Controller\Industry' => 'Admin\Controller\IndustryController',
                        'Admin\Controller\Share' => 'Admin\Controller\ShareController',
                        'Admin\Controller\Experience' => 'Admin\Controller\ExperienceController',
				)
		),
		'router' => array (
				'routes' => array (
						'admin' => array (
								'type' => 'Literal',
								'options' => array (
										// Change this to something specific to your module
										'route' => '/admin',
										'defaults' => array (
												// Change this value to reflect the namespace in which
												// the controllers for your module are found
												'__NAMESPACE__' => 'Admin\Controller',
												'controller' => 'Login',
												'action' => 'index' 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										// This route is a sane default when developing a module;
										// as you solidify the routes for your module, however,
										// you may want to remove it and replace it with more
										// specific routes.
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
						),
						'deletebeyond' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/deletebeyond',
										'defaults' => array (
												'controller' => 'Admin\Controller\Beyond',
												'action' => 'deletebeyond'
										)
								)
						),
						'customizebeyond' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/customizebeyond',
										'defaults' => array (
												'controller' => 'Admin\Controller\Beyond',
												'action' => 'customizebeyond'
										)
								)
						),

						'login' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/login',
										'defaults' => array (
												'controller' => 'Admin\Controller\Login',
												'action' => 'login'
										)
								)
						),
						
						'logout' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/logout',
										'defaults' => array (
												'controller' => 'Admin\Controller\Login',
												'action' => 'logout'
										)
								)
						),
						
						'admin' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/admin',
										'defaults' => array (
												'controller' => 'Admin\Controller\Admin',
												'action' => 'index'
										)
								)
						),
						'dashboard' => array (
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array (
										'route' => '/dashboard',
										'defaults' => array (
												'controller' => 'Admin\Controller\Admin',
												'action' => 'dashboard'
										)
								)
						),
						'dashboard-beyondliving' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/dashboard-beyondliving',
										'defaults' => array (
												'controller' => 'Admin\Controller\Beyond',
												'action' => 'index'
										)
								)
						),
						'dashboard-showcase' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/dashboard-showcase',
										'defaults' => array (
												'controller' => 'Admin\Controller\Showcase',
												'action' => 'index'
										)
								)
						),
						'dashboard-category' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/dashboard-category',
										'defaults' => array (
												'controller' => 'Admin\Controller\Category',
												'action' => 'index'
										)
								)
						),
						'dashboard-showcase-delete' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/dashboard-showcase-delete',
										'defaults' => array (
												'controller' => 'Admin\Controller\Showcase',
												'action' => 'deleteshowcase'
										)
								)
						),
						'dashboard-showcase-customize' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/dashboard-showcase-customize',
										'defaults' => array (
												'controller' => 'Admin\Controller\Showcase',
												'action' => 'customizeshowcase'
										)
								)
						),
						'dashboard-showcase-customize-create-scene' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/dashboard-showcase-customize-create-scene',
										'defaults' => array (
												'controller' => 'Admin\Controller\Showcase',
												'action' => 'createscene'
										)
								)
						),
						
						'dashboard-showcase-customize-update-drop' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/dashboard-showcase-customize-update-drop',
										'defaults' => array (
												'controller' => 'Admin\Controller\Showcase',
												'action' => 'updateondrop'
										)
								)
						),
						'dashboard-showcase-customize-remove' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/dashboard-showcase-customize-remove',
										'defaults' => array (
												'controller' => 'Admin\Controller\Showcase',
												'action' => 'removescene'
										)
								)
						),
						'dashboard-category-add' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/dashboard-category-add',
										'defaults' => array (
												'controller' => 'Admin\Controller\Category',
												'action' => 'newcate'
										)
								)
						),
						'dashboard-category-edit' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/dashboard-category-edit',
										'defaults' => array (
												'controller' => 'Admin\Controller\Category',
												'action' => 'editcate'
										)
								)
						),
						'dashboard-category-delete' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/dashboard-category-delete',
										'defaults' => array (
												'controller' => 'Admin\Controller\Category',
												'action' => 'deletecate'
										)
								)
						),
                        'dashboard-industry' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/dashboard-industry',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Industry',
                                    'action' => 'index'
                                )
                            )
                        ),
                        'dashboard-industry-add' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/dashboard-industry-add',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Industry',
                                    'action' => 'add'
                                )
                            )
                        ),
                        'dashboard-industry-edit' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/dashboard-industry-edit',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Industry',
                                    'action' => 'edit'
                                )
                            )
                        ),
                        'dashboard-industry-delete' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/dashboard-industry-delete',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Category',
                                    'action' => 'delete'
                                )
                            )
                        ),
						'dashboard-category-sub-add' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/dashboard-category-sub-add',
										'defaults' => array (
												'controller' => 'Admin\Controller\Category',
												'action' => 'createsubcate'
										)
								)
						),
						
						'dashboard-category-sub-edit' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/dashboard-category-sub-edit',
										'defaults' => array (
												'controller' => 'Admin\Controller\Category',
												'action' => 'editsubcate'
										)
								)
						),

                    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~your job block
                        'admin-job' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-job',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Job',
                                    'action' => 'index'
                                )
                            )
                        ),
                       'job-posting' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/job-posting',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Job',
                                    'action' => 'jobposting'
                                )
                            )
                        ),
                        'admin-feature' => array ('type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-feature',
                                'defaults' => array ('controller' => 'Admin\Controller\Feature','action' => 'index')
                            )
                        ),
                        'admin-employer' => array ('type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-employer',
                                'defaults' => array ('controller' => 'Admin\Controller\Employer','action' => 'index')
                            )
                        ),
                        'job-posting' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/job-posting',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Job',
                                    'action' => 'jobposting'
                                )
                            )
                        ),
                        'job-editing' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/job-editing',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Job',
                                    'action' => 'jobediting'
                                )
                            )
                        ),
                        'job-delete' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/job-delete',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Job',
                                    'action' => 'jobdelete'
                                )
                            )
                        ),
                        'resume-search' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/resume-search',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Job',
                                    'action' => 'resumesearch'
                                )
                            )
                        ),
                        'resume-purchase' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/resume-purchase',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Job',
                                    'action' => 'resumepurchase'
                                )
                            )
                        ),
                        'resume-view' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/resume-view',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Job',
                                    'action' => 'resumeview'
                                )
                            )
                        ),
                        'admin-feature-new' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-feature-new',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Feature',
                                    'action' => 'newfeature'
                                )
                            )
                        ),
                        'admin-feature-edit' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-feature-edit',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Feature',
                                    'action' => 'editfeature'
                                )
                            )
                        ),
                        'admin-feature-delete' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-feature-delete',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Feature',
                                    'action' => 'deletefeature'
                                )
                            )
                        ),
                        'admin-job-seeker' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-job-seeker',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Seeker',
                                    'action' => 'index'
                                )
                            )
                        ),
                        'admin-resume-new' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-resume-new',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Seeker',
                                    'action' => 'newresume'
                                )
                            )
                        ),
                        'admin-resume-editing' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-resume-editing',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Seeker',
                                    'action' => 'editresume'
                                )
                            )
                        ),
                        'admin-resume-delete' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-resume-delete',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Seeker',
                                    'action' => 'deleteresume'
                                )
                            )
                        ),
                        'admin-resume-year' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-resume-year',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Seeker',
                                    'action' => 'yearexperience'
                                )
                            )
                        ),
                        'admin-resume-education' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-resume-education',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Seeker',
                                    'action' => 'education'
                                )
                            )
                         ),
                        'admin-resume-neweducation' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-resume-neweducation',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Seeker',
                                    'action' => 'neweducation'
                                )
                            )
                        ),
                        'admin-resume-editeducation' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-resume-editeducation',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Seeker',
                                    'action' => 'editeducation'
                                )
                            )
                        ),
                        'admin-resume-deleteeducation' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-resume-deleteeducation',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Seeker',
                                    'action' => 'deleteeducation'
                                )
                            )
                        ),
                        'admin-resume-newyear' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-resume-newyear',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Seeker',
                                    'action' => 'newyear'
                                )
                            )
                        ),
                        'admin-resume-edityear' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-resume-edityear',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Seeker',
                                    'action' => 'edityear'
                                )
                            )
                        ),
                        'admin-resume-deleteyear' => array (
                            'type' => 'Literal',
                            'options' => array (
                                'route' => '/admin-resume-deleteyear',
                                'defaults' => array (
                                    'controller' => 'Admin\Controller\Seeker',
                                    'action' => 'deleteyear'
                                )
                            )
                        ),
                    'admin-userinfo' => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/admin-userinfo',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Seeker',
                                'action' => 'userinfo'
                            )
                        )
                    ),
                    'admin-resume-sample' => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/admin-resume-sample',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Seeker',
                                'action' => 'resumesample'
                            )
                        )
                    ),
                    'admin-seeker-jobsearch' => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/admin-seeker-jobsearch',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Seeker',
                                'action' => 'jobsearch'
                            )
                        )
                    ),
                    'advertisement' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/advertisement[/][:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Advertisement',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'member' => array (
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array (
                            'route' => '/member',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Login',
                                'action' => 'employerlogin'
                            )
                        )
                    ),
                    'admin-member' => array (
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array (
                            'route' => '/admin-member',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Admin',
                                'action' => 'member'
                            )
                        )
                    ),
                    'seeker' => array (
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array (
                            'route' => '/seeker',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Login',
                                'action' => 'seekerlogin'
                            )
                        )
                    ),
                    'admin-seeker' => array (
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array (
                            'route' => '/admin-seeker',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Admin',
                                'action' => 'seeker'
                            )
                        )
                    ),
                    'member-admin-job' => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/member-admin-job',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Employer',
                                'action' => 'index'
                            )
                        )
                    ),
                    'member-job-posting' => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/member-job-posting',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Employer',
                                'action' => 'jobposting'
                            )
                        )
                    ),
                    'member-job-editing' => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/member-job-editing',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Employer',
                                'action' => 'jobediting'
                            )
                        )
                    ),
                    'member-job-delete' => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/member-job-delete',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Employer',
                                'action' => 'jobdelete'
                            )
                        )
                    ),
                    'admin-education' => array (
                        'type' => 'Segment',
                        'options' => array (
                            'route' => '/admin-education[/:action[/:id]]',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Education',
                                'action' => 'index'
                            )
                        )
                    ),
                    'approval-education' => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/approval-education',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Education',
                                'action' => 'approval'
                            )
                        )
                    ),
                    'delete-education' => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/delete-education',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Education',
                                'action' => 'delete'
                            )
                        )
                    ),
                    'resume-request' => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/resume-request',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Job',
                                'action' => 'resumerequest'
                            )
                        )
                    ),
                    'resume-request-view' => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/resume-request-view',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Job',
                                'action' => 'resumerequestview'
                            )
                        )
                    ),
                    'approvalresume' => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/approvalresume',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Job',
                                'action' => 'approvalresume'
                            )
                        )
                    ),
                    'newpurchase' => array (
                        'type' => 'Literal',
                        'options' => array (
                            'route' => '/newpurchase',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Job',
                                'action' => 'newpurchase'
                            )
                        )
                    ),

                    'admin-share' => array (
                        'type' => 'Segment',
                        'options' => array (
                            'route' => '/admin-share[/][:action][/:id]',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Share',
                                'action' => 'index'
                            )
                        )
                    ),


                    'admin-experience' => array (
                        'type' => 'Segment',
                        'options' => array (
                            'route' => '/admin-experience[/][:action][/:id]',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Experience',
                                'action' => 'index'
                            )
                        )
                    ),

                ),

		),
		'view_manager' => array (
				'template_path_stack' => array (
						'Admin' => __DIR__ . '/../view'
				)
		) 
);
