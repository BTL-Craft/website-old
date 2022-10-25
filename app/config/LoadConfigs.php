<?php

class env
{
    public static function load($class, $key)
    {
        if (array_key_exists($class, $config = self::load_all())) {
            if (array_key_exists($key, $config[$class])) {
                return $config[$class][$key];
            }
        }
    }

    public static function load_all()
    {
        return json_decode(file_get_contents(__DIR__ . '/../../.env.json'), true);
    }

    public static function update($class, $key, $value)
    {
        if (array_key_exists($class, $config = self::load_all())) {
            if (array_key_exists($key, $config[$class])) {
                $config[$class][$key] = $value;
                $f = fopen(__DIR__ . '/../../.env.json', 'w');
                fwrite($f, json_encode($config, JSON_PRETTY_PRINT));
                fclose($f);

                return true;
            }
        }
    }
}

