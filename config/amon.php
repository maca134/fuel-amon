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

return array(
    /*
    * The protocol can either be http or zeromq
    *
    * More info on ZeroMQ goto http://www.zeromq.org/
    */
    'protocol' => 'http',
    /*
    * The IP or hostname of your Amon instance
    */
    'host' => '127.0.0.1',
    /*
    * The port of your Amon instance
    */
    'port' => '2464',
    /*
    * The application key. This is set in your Amonplus web interface
    */
    'application_key' => '',
);
