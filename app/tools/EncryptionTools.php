<?php

namespace App\Tools;

use \env;

class EncryptionTools
{
    /**
     * 加密字符串
     * 
     * @param string $data
     * @return false|string
     */
    public static function encrypt($data)
    {
        $config = env::load_class('app');
        if ($config['encrypt_token'] == '') {
            env::update('app', 'encrypt_token', base64_encode(openssl_random_pseudo_bytes(40)));
        }

        $ivLength = openssl_cipher_iv_length($config['encryptMethod']);
        $iv = openssl_random_pseudo_bytes($ivLength, $isStrong);
        if (false === $iv && false == $isStrong) {
            return false;
        }

        return openssl_encrypt(base64_encode($data), $config['encryptMethod'], $config['encrypt_token'], 0, $iv) . '>>>' . base64_encode($iv);
    }

    /**
     * 解密字符串
     * 
     * @param string $data
     * @return false|string
     */
    public static function decrypt($data)
    {
        $source = explode('>>>', $data);
        $config = env::load_class('app');
        if ($config['encrypt_token'] == '') {
            return false;
        }

        return base64_decode(openssl_decrypt($source[0], $config['encryptMethod'], $config['encrypt_token'], 0, base64_decode($source[1])));
    }

    /**
     * 加密数组
     * 
     * @param array $data
     * @return string
     */
    public static function encrypt_array($data)
    {
        return self::encrypt(json_encode($data));
    }

    /**
     * 解密数组
     * 
     * @param string $data
     * @return array
     */
    public static function decrypt_array($data)
    {
        return json_decode(self::decrypt($data));
    }

    /**
     * 生成token
     * 
     * @param int $length
     * @return string
     */
    public static function generate_token($length)
    {
        return substr(preg_replace('/[[:punct:]]/i', '', base64_encode(openssl_random_pseudo_bytes($length))), 0, $length);
    }

    /**
     * 生成随机哈希
     * 
     * @param int $length
     * @return string
     */
    public static function generate_random_hash($length)
    {
        $source = '';
        for ($i = 0; $i < $length / 40; $i++) {
            $source .= sha1(self::generate_token(40));
        }

        return substr(str_shuffle($source), 0, $length);
    }
}
