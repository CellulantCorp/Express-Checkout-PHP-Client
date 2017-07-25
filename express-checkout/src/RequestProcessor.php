<?php

namespace Mula;

use Mula\Libraries\Mcrypt;

class RequestProcessor
{
    /**
     * Merchant's iv key.
     *
     * @var string
     */
    private $iv_key;

    /**
     * Merchant's secret key.
     *
     * @var string
     */
    private $secret_key;

    /**
     * Merchant's access key.
     *
     * @var string
     */
    private $access_key;

    /**
     * Merchant's country code.
     *
     * @var string
     */
    private $country_code;

    /**
     * RequestProcessor constructor.
     *
     * @param $iv_key
     * @param $secret_key
     * @param $access_key
     * @param $country_code
     */
    public function __construct($iv_key, $secret_key, $access_key, $country_code)
    {
        $this->iv_key = $iv_key;
        $this->secret_key = $secret_key;
        $this->access_key = $access_key;
        $this->country_code = $country_code;
    }

    /**
     * Process the passed in parameters and return the response as needed.
     *
     * @param array $request Request Data
     * @return array
     */
    public function process($request)
    {
        $mcrypt = new MCrypt($this->iv_key, $this->secret_key);

        //Encrypt
        $encrypted = $mcrypt->encrypt(json_encode($request, true));

        return array(
            'PARAMS' => $encrypted,
            'ACCESS_KEY' => $this->access_key,
            'COUNTRY_CODE' => $this->country_code
        );
    }
}