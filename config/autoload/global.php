<?php 
return array(
		'db' => array(
				'driver'         => 'Pdo',
				'dsn'            => 'mysql:dbname=yourjob;host=localhost',
				'driver_options' => array(
						PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
				),
				'username' => 'root',
				'password' => 'jan121984'
		),
		'service_manager' => array(
				'factories' => array(
						'Zend\Db\Adapter\Adapter'
						=> 'Zend\Db\Adapter\AdapterServiceFactory',
				),
		),
);