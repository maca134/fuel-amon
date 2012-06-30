<?php
namespace Amon;

class Amon_Zeromq {

    private $host = '';
	private $port = '';
	private $key = '';
	private $requester;
	
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
		var_dump($zeromq_data); 
		die;
		
        $this->requester->send(json_encode($zeromq_data), \ZMQ::MODE_NOBLOCK);
    }
}