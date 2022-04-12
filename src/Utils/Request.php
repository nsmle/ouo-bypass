<?php

/**
 * ouo-bypass
 *
 * @see        https://github.com/nsmle/ouo-bypass/ The ouo-bypass GitHub project
 * @author     Fiki Pratama (nsmle) <fikiproductionofficial@gmail.com>
 */

declare(strict_types=1);

namespace Nsmle\OuoBypass\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\SessionCookieJar;

class Request
{
    /**
     * @var client
     */
    public $client;

    public function __construct()
    {
        $jar          = new SessionCookieJar('PHPSESSID', true);
        $this->client = new Client(array('cookies' => $jar));
    }

    /**
     * @param string endpoint
     */
    public function fetchData(string $endpoint): object
    {
        $headers = array(
            'headers' => array(
                'content-type' => 'application/x-www-form-urlencoded',
            ),
        );

        $res  = $this->client->request('GET', $endpoint, $headers);

        return $res->getBody();
    }

    /**
     * @param string endpoint
     * @param array  formParameters
     * @param array  opt
     */
    public function postData(string $endpoint, array $formParameters = array(), array $opt = array()): object
    {
        $options = array(
            'headers' => array(
                'content-type' => 'application/x-www-form-urlencoded',
            ),
        );

        if (count($formParameters) > 0) {
            $options = array_merge($options, array(
                'form_params' => $formParameters,
            ));
        }

        if (count($opt) > 0) {
            $options = array_merge($options, $opt);
        }

        return $this->client->request('POST', $endpoint, $options);
    }
}
