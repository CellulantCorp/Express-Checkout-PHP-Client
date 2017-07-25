<?php

namespace Mula;

use Mula\Libraries\Mcrypt;

class ResponseProcessor
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
     * ResponseProcessor constructor.
     *
     * @param $iv_key
     * @param $secret_key
     */
    public function __construct($iv_key, $secret_key)
    {
        $this->iv_key = $iv_key;
        $this->secret_key = $secret_key;
    }

    /**
     * Process the encrypted code passed from the merchant
     * and retrieve the data passed.
     *
     * @param $code
     * @return mixed
     */
    public function process($code)
    {
        return json_decode(
            (new MCrypt($this->iv_key, $this->secret_key))->decrypt($code),
            true
        );
    }
}