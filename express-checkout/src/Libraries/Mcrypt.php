<?php

namespace Mula\Libraries;

class Mcrypt
{
    /**
     * Merchant's iv key.
     *
     * @var mixed|string
     */
    private $iv;

    /**
     * Merchant's secret key.
     *
     * @var mixed|string
     */
    private $key;

    /**
     * MCrypt constructor.
     *
     * @param $iv_key
     * @param $secret_key
     */
    public function __construct($iv_key, $secret_key)
    {
        $this->iv = $iv_key;
        $this->key = $secret_key;
    }

    /**
     * Encrypt the data with the iv and secret key.
     *
     * @param $str
     * @return string
     */
    public function encrypt($str)
    {
        $iv = $this->iv;

        $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);

        mcrypt_generic_init($td, $this->key, $iv);

        $encrypted = mcrypt_generic($td, $str);

        mcrypt_generic_deinit($td);

        mcrypt_module_close($td);

        return bin2hex($encrypted);
    }

    /**
     * Decrypt the encrypted code back to the original data using the merchant's
     * iv and secret key.
     *
     * @param $code
     * @return string
     */
    public function decrypt($code)
    {
        $code = $this->hex2bin($code);

        $iv = $this->iv;

        $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);

        mcrypt_generic_init($td, $this->key, $iv);

        $decrypted = mdecrypt_generic($td, $code);

        mcrypt_generic_deinit($td);

        mcrypt_module_close($td);

        return utf8_encode(trim($decrypted));
    }

    /**
     * Turns the hex to binary.
     *
     * @param $hexdata
     * @return string
     */
    protected function hex2bin($hexdata)
    {
        $bindata = '';

        for ($i = 0; $i < strlen($hexdata); $i += 2) {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }

        return $bindata;
    }
}