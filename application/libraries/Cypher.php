<?php

class Cypher {

    private $encryption_key;

    //declare(strict_types=1);

    public function __construct(){

        $this->encryption_key = 'iDl4WWUa65wqy95FJraGOmRsQChCbNvs';
    }

    function safeEncrypt($message){
        return @openssl_encrypt($message, "aes128", $this->encryption_key);
    }

    /**
     * Decrypt a message
     * 
     * @param string $encrypted - message encrypted with safeEncrypt()
     * @return string
     * @throws Exception
     */
    function safeDecrypt($encrypted)
    {   
        return @openssl_decrypt($encrypted, "aes128", $this->encryption_key);
    }

}