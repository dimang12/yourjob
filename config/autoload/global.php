<?php 
return array(
		'db' => array(
				'driver'         => 'Pdo',
				'dsn'            => 'mysql:dbname=yourjob;host=166.62.8.49',
				'driver_options' => array(
						PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
				),
				'username' => 'yourjob',
				'password' => 'Jan121984!'
		),
		'service_manager' => array(
				'factories' => array(
						'Zend\Db\Adapter\Adapter'
						=> 'Zend\Db\Adapter\AdapterServiceFactory',
				),
		),
);