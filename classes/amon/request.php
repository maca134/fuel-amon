<?php

namespace Amon;

class Amon_Request {

    protected static $config = array();
    protected static $driver;

    /**
     * Init, config loading.
     * @throws Amon_Request_Exception 
     */
    public static function _init() {
        \Config::load('amon', true);
        static::$config = \Config::get('amon');
        if (!class_exists('\ZMQContext')) {
            static::$config['protocol'] = 'http';
        }
        $class = 'Amon_Request_' . ucwords(strtolower(static::$config['protocol']));
        if (!class_exists($class)) {
            throw new Amon_Request_Exception('Can not find request driver');
        }
		
		try {
			static::$driver = new $class(static::$config['host'], static::$config['port'], static::$config['application_key']);
		} catch (Amon_Request_Exception $e) {
			throw $e;
		}
    }
    
    /**
     * Sends a request to Amon
     * @param array $data
     * @param string $type
     * @throws Amon_Request_Exception 
     */
    public static function request(array $data, $type = 'exception') {
        if ($type != 'exception' && $type != 'log') {
            throw new Amon_Request_Exception('Request type can only be exception or log');
        }
        static::$driver->request($data, $type);
    }

}

class Amon_Request_Exception extends \FuelException { }
