<?php
class Crypt {
    private $secretkey = 'ccg rocks the cogs socks off';

    // Encrypt it
    public function encrypt($text) {
        $data = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->secretkey, $text, MCRYPT_MODE_ECB, 'keee');
        return base64_encode($data);
    }

    // Decrypt it
    public function decrypt($text) {
        $text = base64_decode($text);
        return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->secretkey, $text, MCRYPT_MODE_ECB, 'keee');
    }
}
?>