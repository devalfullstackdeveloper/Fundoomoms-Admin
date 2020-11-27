<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customsecurity {

	protected $CI;

    /*
	** We'll use a constructor, as you can't directly call a function
    ** from a property definition.
    */
    public function __construct()
    {
        /*
        ** Assign the CodeIgniter super-object
        */
        $this->CI =& get_instance();
        /*
        ** Define OpenSsl Encrytion keys here
        */
        define('AES_256_CBC', 'aes-256-cbc');
        define('ENC_KEY', md5('icobs_enc_key'));
        define('SEC_KEY',openssl_random_pseudo_bytes(64));
        define('IV',substr(hash('sha256', SEC_KEY), 0, 16));
        /*
        ** Get Sql Key
        */
        define('SQLKEY', md5('icobs_sql_key'));
    }

    /*
    ** Pass Csrf Tokens here
    */
    public function getcsrf() {
        $csrf = array(
            'name' => $this->CI->security->get_csrf_token_name(),
            'hash' => $this->CI->security->get_csrf_hash()
        );
        return $csrf;
    }

    public function sanitizeinput($input) {
        return $this->CI->security->xss_clean($input);
    }

    public function encrypt($input) {
        $parts = openssl_encrypt($input, AES_256_CBC, ENC_KEY, 0, IV);
        $encrypted = $parts . ':' . base64_encode(IV).':'.openssl_digest($input, 'sha512');
        return $encrypted;
    }

    public function decrypt($input) {
        $parts = explode(':', $input);
        $decrypted = openssl_decrypt($parts[0], AES_256_CBC, ENC_KEY, 0, base64_decode($parts[1]));
        return $decrypted;
    }

    public function opsslhash($input) {
        return openssl_digest($input, 'sha512');
    }

    public function sqlkey() {
        return SQLKEY;
    }

    public function aesenc($input) {
        return "AES_ENCRYPT('".$input."', UNHEX(SHA2('".SQLKEY."',512)))";
    }

    public function aesdec($input) {
        return "AES_DECRYPT(".$input.", UNHEX(SHA2('".SQLKEY."',512)))";
    }

    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}