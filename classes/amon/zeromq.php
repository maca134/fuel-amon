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
 
namespace Amon;

class Amon_Zeromq {

	/**
     * @var String Ip or hostname of the Amon instance.
     */
    private $host = '';
	
	/**
     * @var String Port of the Amon instance.
     */
    private $port = '';
	
	/**
     * @var String Application key of the Amon instance.
     */
    private $key = '';
	
	/**
     * @var ZMQSocket ZMQSocket object.
     */
	private $requester;
	
    /**
     * Constructor
     *
     * @param Exception Exception to be parsed for Amon
     *
     * @return null
     */
    public function __construct($host, $port, $key) {
        $this->host = $host;
		$this->port = $port;
		$this->key = $key;
        $context = new \ZMQContext();
        $this->requester = new \ZMQSocket($context, \ZMQ::SOCKET_DEALER);
		$url = 'tcp://' . $this->host . ':' . $this->port;
        $this->requester->connect($url);
        $this->requester->setSockOpt(\ZMQ::SOCKOPT_LINGER, 0);
    }
    /**
     * Make a zeromq request
     *
     * @param array  $data
     *
     * @return void
     */
    public function request(array $data, $type = 'exception') {
		$zeromq_data = array();
		if (!empty($this->key)) {
			$zeromq_data['app_key'] = $this->key;
		}
		$zeromq_data['content'] = $data;
		$zeromq_data['type'] = $type;
		$this->requester->send(json_encode($zeromq_data), \ZMQ::MODE_NOBLOCK);
    }
}