<?php

class env
{
    /**
     * 加载一项设置
     * 
     * @param string $class
     * @param string $key 
     * @return string
     */
    public static function load($class, $key)
    {
        if (array_key_exists($class, $config = self::load_all())) {
            if (array_key_exists($key, $config[$class])) {
                return $config[$class][$key];
            }
        }
    }

    /**
     * 加载一组设置
     * 
     * @param string $class
     * @return array
     */
    public static function load_class($class)
    {
        if (array_key_exists($class, $config = self::load_all())) {
            return $config[$class];
        }
    }

    /**
     * 加载所有设置
     * 
     * @return array
     */
    public static function load_all()
    {
        return json_decode(file_get_contents(__DIR__ . '/../../env.json'), true);
    }

    /**
     * 修改一项设置
     * 
     * @param string $class
     * @param string $key 
     * @param string $value
     * @return string
     */
    public static function update($class, $key, $value)
    {
        if (array_key_exists($class, $config = self::load_all())) {
            if (array_key_exists($key, $config[$class])) {
                $config[$class][$key] = $value;
                $f = fopen(__DIR__ . '/../../env.json', 'w');
                fwrite($f, json_encode($config, JSON_PRETTY_PRINT));
                fclose($f);

                return true;
            }
        }
    }
}
