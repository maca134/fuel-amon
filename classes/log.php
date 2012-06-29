<?php

/**
 * Amon: Integrate FuelPHP with Amon Exception & Logging
 *
 * @package    Amon
 * @version    v0.1
 * @author     Matthew McConnell & James Mallison
 * @license    MIT License
 * @link       http://github.com/maca134/fuelphp-amon
 */

namespace Amon;

class Log extends \Fuel\Core\Log {

    /**
     * Logs a message with the Info Log Level
     *
     * @param   string  $msg     The log message
     * @param   string  $method  The method that logged
     * @return  bool    If it was successfully logged
     */
    public static function info($msg, $method = null) {
        $tags = array(__METHOD__);
        $tags = ($method !== null) ? array_merge($tags, array($method)) : array();
        static::amon($msg, $tags);
        return parent::write($msg, $method);
    }

    /**
     * Logs a message with the Debug Log Level
     *
     * @param   string  $msg     The log message
     * @param   string  $method  The method that logged
     * @return  bool    If it was successfully logged
     */
    public static function debug($msg, $method = null) {
        $tags = array(__METHOD__);
        $tags = ($method !== null) ? array_merge($tags, array($method)) : array();
        static::amon($msg, $tags);
        return parent::write($msg, $method);
    }

    /**
     * Logs a message with the Warning Log Level
     *
     * @param   string  $msg     The log message
     * @param   string  $method  The method that logged
     * @return  bool    If it was successfully logged
     */
    public static function warning($msg, $method = null) {
        $tags = array(__METHOD__);
        $tags = ($method !== null) ? array_merge($tags, array($method)) : array();
        static::amon($msg, $tags);
        return parent::write($msg, $method);
    }

    /**
     * Logs a message with the Error Log Level
     *
     * @param   string  $msg     The log message
     * @param   string  $method  The method that logged
     * @return  bool    If it was successfully logged
     */
    public static function error($msg, $method = null) {
        $tags = array(__METHOD__);
        $tags = ($method !== null) ? array_merge($tags, array($method)) : array();
        static::amon($msg, $tags);
        return parent::write($msg, $method);
    }

    /**
     * Send log information to Amon
     *
     * @param	string	$message	The log message
     * @param	mixed	$tag	Tags for the log message
     * @return  void
     */
    protected static function amon($message, $tags) {
        $data = array(
            'message' => $message,
            'tags' => $tags
        );
        Amon_Request::request($data, 'log');
    }

}