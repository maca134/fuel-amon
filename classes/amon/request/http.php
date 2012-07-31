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

class Amon_Request_Http {

    private $host = '';
    private $port = '';
    private $key = '';

    public function __construct($host, $port, $key) {
        $this->host = $host;
        $this->port = $port;
        $this->key = $key;
    }

    /**
     * Make request
     *
     * @param string $url
     * @param array  $data
     * @param string $refer
     *
     * @return array
     */
    public function request(array $data, $type = 'exception') {
        $params = array(
            'http' => array(
                'header' => 'Content-Type: application/x-www-form-urlencoded' . "\r\n",
                'method' => 'POST',
                'content' => json_encode($data),
                'timeout' => 5,
            )
        );

        $context = stream_context_create($params);
        $url = 'http://' . $this->host . ':' . $this->port . '/api/' . $type;
        if (!empty($this->key)) {
            $url = sprintf("%s/%s", $url, $this->key);
        }
        $fp = @fopen($url, 'rb', false, $context);
        if (!$fp) {
            throw new Amon_Request_Http_Exception('Can not open ' . $url);
        }

        $response = stream_get_contents($fp);
        if (!$response) {
            throw new Amon_Request_Http_Exception('Problem sending POST');
        }

        // split the result header from the content
        $result = explode("\r\n\r\n", $response, 2);
        $header = isset($result[0]) ? $result[0] : '';
        $content = isset($result[1]) ? $result[1] : '';

        // return as structured array:
        return array(
            'status' => 'ok',
            'header' => $header,
            'content' => $content,
        );
    }

}

class Amon_Request_Http_Exception extends Amon_Request_Exception {
    
}
