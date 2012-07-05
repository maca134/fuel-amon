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

class Amon_Http_Exception extends \FuelException {}

class Amon_Http
{
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
     * Constructor
     *
     * @param Exception Exception to be parsed for Amon
     *
     * @return null
     */
    public function __construct($host, $port, $key)
    {
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
    public function request(array $data, $type = 'exception')
    {
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
        $fp = fopen($url, 'rb', false, $context);

        $response = @stream_get_contents($fp);

        if (!$fp) {
            return false;
        }

        if ($response === false) {
            $error = sprintf('Problem sending POST to %s', $url);
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
            'params' => $params,
            'url' => $url,
            'response' => $response
        );
    }

}
