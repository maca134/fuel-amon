<?php

/**
 * Amon: Integrate FuelPHP with Amon Exception & Logging
 *
 * @package    Amon
 * @version    v0.1
 * @author     Matthew McConnell
 * @license    MIT License
 * @link       http://github.com/maca134/fuelphp-amon
 */

Autoloader::add_core_namespace('Amon');

Autoloader::add_classes(array(
    'Amon\\Error' 				=> __DIR__ . '/classes/error.php',
    'Amon\\Log' 				=> __DIR__ . '/classes/log.php',
    'Amon\\Amon_Data' 			=> __DIR__ . '/classes/amon/data.php',
    'Amon\\Amon_Request' 		=> __DIR__ . '/classes/amon/request.php',
    'Amon\\Amon_Request_Http' 	=> __DIR__ . '/classes/amon/request/http.php',
    'Amon\\Amon_Request_Zeromq' => __DIR__ . '/classes/amon/request/zeromq.php',
));
