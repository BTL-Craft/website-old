<?php

namespace App\Database;

use \PDO,\PDOStatement,\PDOException;

class Execute
{
    /*
    |--------------------------------------------------------------------------
    | 操作数据库
    |--------------------------------------------------------------------------
    */
    public static function connect()
    {
        /*
        |--------------------------------------------------------------------------
        | 连接数据库
        |--------------------------------------------------------------------------
        |
        | 在执行Mysql操作之前调用此方法来连接数据库
        | 返回值$conn为PDO对象
        |
        */
        $config = json_decode(file_get_contents(__DIR__ . "/../../config/mysql.json"), true);
        $servername = $config['servername'];
        $dbname = $config['dbname'];
        try {
            /* 创建连接 */
            $conn = new PDO(
                "mysql:host=$servername;dbname=$dbname",
                $config['username'],
                $config['password']
            );
            /* 设置 PDO 错误模式为异常 */
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            Logging($e->getMessage());
        }

        return $conn;
    }

    public static function execute_command($command, $data)
    {
        /*
        |--------------------------------------------------------------------------
        | 执行SQL语句，支持预编译模式
        |--------------------------------------------------------------------------
        |
        | $command：要执行的SQL语句或模板，
        | 示例：INSERT INTO `usr` (`eml`, `passwd`) VALUES (:eml, :passwd);")
        | $data：要向模板中填入的信息，$data可以是数组或null，
        | 如果传入null则直接执行$command指定的SQL语句
        | 返回值为执行结果，如果是查询语句可以返回查询结果
        | 结果只允许返回一次，所以你应该使用WHERE子句
        |
        */
        $conn = self::connect(); // 创建连接
        $pdo = $conn->prepare($command); // 预编译SQL语句
        if ($data == null) {
            try {
                $pdo->execute();

                return $pdo->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                Logging($e->getMessage());

                return -1;
            }
        } else {
            try {
                foreach ($data as $param => $value) {
                    ${$value} = $value;
                    $pdo->bindParam($param, ${$value});
                }

                $pdo->execute();

                return $pdo->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                Logging($e->getMessage());

                return -1;
            }
        }
    }

    public static function read_all($tbname)
    {
        /*
        |--------------------------------------------------------------------------
        | 读取某个表的全部数据
        |--------------------------------------------------------------------------
        |
        | $tbname：数据表的名称
        | 备忘录 - 返回值说明：
        |   假如$data是返回值
        |   $data[0]['a']表示第0条数据里的a字段
        |
        */
        $conn = self::connect();
        $pdo = $conn->prepare("SELECT * FROM {$tbname}"); // 预编译SQL语句

        /* 绑定与执行 */
        $pdo->execute();
        $result = $pdo->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
