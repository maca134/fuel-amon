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

class Error extends \Fuel\Core\Error {

    /**
     * Amon Exception handler
     *
     * @param   Exception  $e  the exception
     * @return  bool
     */
    public static function exception_handler(\Exception $e) {
        self::handle_exception($e);
        $return = parent::exception_handler($e);
        if ($return !== null) {
            return $return;
        }
    }

    /**
     * Amon Error handler
     *
     * @param   int     $severity  the severity code
     * @param   string  $message   the error message
     * @param   string  $filepath  the path to the file throwing the error
     * @param   int     $line      the line number of the error
     * @return  bool    whether to continue with execution
     */
    public static function error_handler($severity, $message, $filepath, $line) {
        switch ($severity) {
            case E_NOTICE:
            case E_USER_NOTICE:
                $e = new Amon_Php_Notice($message, $severity, $filepath, $line);
                break;

            case E_WARNING:
            case E_USER_WARNING:
                $e = new Amon_Php_Warning($message, $severity, $filepath, $line);
                break;

            case E_STRICT:
                $e = new Amon_Php_Strict($message, $severity, $filepath, $line);
                break;

            case E_PARSE:
                $e = new Amon_Php_Parse($message, $severity, $filepath, $line);
                break;

            default:
                $e = new Amon_Php_Error($message, $severity, $filepath, $line);
        }
        self::handle_exception($e);
        return parent::error_handler($severity, $message, $filepath, $line);
    }

    /**
     * Amon PHP shutdown handler
     *
     * @return  void
     */
    public static function shutdown_handler() {
        $last_error = error_get_last();

        // Only show valid fatal errors
        if ($last_error AND in_array($last_error['type'], static::$fatal_levels)) {
            $severity = static::$levels[$last_error['type']];
            logger(\Fuel::L_ERROR, $severity . ' - ' . $last_error['message'] . ' in ' . $last_error['file'] . ' on line ' . $last_error['line']);

            $error = new \ErrorException($last_error['message'], $last_error['type'], 0, $last_error['file'], $last_error['line']);
            static::exception_handler($error);
            if (\Fuel::$env != \Fuel::PRODUCTION) {
                static::show_php_error($error);
            } else {
                static::show_production_error($error);
            }

            exit(1);
        }
    }

    /**
     * Amon Exception handler
     *
     * @param   Exception  $e  the exception
     * @return  bool
     */
    private static function handle_exception($exception) {
        $data = new Amon_Data($exception);
        Amon_Request::request($data->data, 'exception');
    }

}

class Amon_Php_Exception extends \ErrorException {

    function __construct($errstr, $errno, $errfile, $errline) {
        parent::__construct($errstr, 0, $errno, $errfile, $errline);
    }

}

class Amon_Php_Error extends Amon_Php_Exception {
    
}

class Amon_Php_Warning extends Amon_Php_Exception {
    
}

class Amon_Php_Strict extends Amon_Php_Exception {
    
}

class Amon_Php_Parse extends Amon_Php_Exception {
    
}

class Amon_Php_Notice extends Amon_Php_Exception {
    
}