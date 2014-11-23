<?php
namespace che;

/**
 * PHP wrapper for Yo App API (http://justyo.co)
 *
 * @link https://github.com/chekalskiy/yoapp-php
 * @author Ilya Chekalskiy <ilya@chekalskiy.ru>
 */
class Yo
{
    protected $apiToken;
    protected $apiUrl = 'http://api.justyo.co/';

    public function __construct($apiToken)
    {
        if (!empty($apiToken))
            $this->apiToken = $apiToken;
    }

    /**
     * Send A Yo To All Subscribers
     *
     * @param  string  $link
     * @return boolean
     */
    public function sendAll($link = false)
    {
        $params = array(
            'method'   => 'POST',
            'endpoint' => 'yoall'
        );

        if (!empty($link))
            $params['post'] = array('link' => $link);

        $this->_request($params);

        return true;
    }

    /**
     * Yo Individual Usernames
     *
     * @param  string  $username
     * @param  string  $link
     * @return boolean
     */
    public function sendUser($username, $link = false)
    {
        $params = array(
            'method'   => 'POST',
            'endpoint' => 'yo',
            'post'     => array(
                'username' => $username
            )
        );

        if (!empty($link))
            $params['post']['link'] = $link;

        $response = $this->_request($params);

        if (isset($response['result']) && $response['result'] == 'OK')
            return true;
        return false;
    }

    /**
     * Count Total Subscribers
     *
     * @return int|boolean
     */
    public function subscribersCount()
    {
        $response = $this->_request(array(
            'method'   => 'GET',
            'endpoint' => 'subscribers_count'
        ));

        if (isset($response['result']))
            return intval($response['result']);
        return false;
    }

    /**
     * Sending request
     *
     * @return mixed
     */
    protected function _request($params = array())
    {
        $method = (isset($params['method'])) ? strtoupper($params['method']) : 'GET';
        $apiToken = $this->apiToken;

        if (empty($apiToken))
            throw new YoException('You need to setup your token. See http://yoapi.justyo.co/', 400);

        $url = $this->apiUrl . $params['endpoint'] . '/';

        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_USERAGENT      => 'che\yoapp-php (https://github.com/chekalskiy/yoapp-php)'
        );

        switch ($method) {
            case 'POST':
                $options[CURLOPT_POST] = true;

                $post = (isset($params['post'])) ? $params['post'] : array();
                $options[CURLOPT_POSTFIELDS] = array_merge(array(
                    'api_token' => $apiToken
                ), $post);
                break;

            default:
                $query = http_build_query(array('api_token' => $apiToken));

                $options[CURLOPT_URL] .= '?' . $query;
        }

        $ch = curl_init();

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);

        $result = json_decode($response, true);

        // Handle errors
        $code = (isset($info['http_code'])) ? $info['http_code'] : 500;
        if ($code >= 300 || $code < 200 || $result === false) {
            if ($result && isset($result['error'])) {
                $errMessage = $result['error'];
            } elseif (!empty($response)) {
                $errMessage = $response;
            } else {
                $errMessage = "Something is broken, make sure you set right token or other required params";
            }

            throw new YoException($errMessage, $code);
        }

        if ($result) {
            if (isset($result['error'])) {
                throw new YoException($result['error'], $result['code']);
            }

            return $result;
        }
    }
}

class YoException extends \Exception {}
