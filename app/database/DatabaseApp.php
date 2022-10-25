<?php

namespace App\Database;

use \DateTime;

class DatabaseApp
{
    public static function clear()
    {
        $database = new Execute;

        $result = $database->execute_command(
            "TRUNCATE TABLE `users`",
            null
        );

        /* 检查返回值*/
        if (gettype($result) == 'integer') {
            if ($result == -1) {
                echo '数据库错误！请查看日志文件';
                return -1;
            }
        }

        $loginfo = '[' . date("H:i:s") . '] [MySQL/INFO]: Cleared table: `users`' . "\n";
        fwrite(fopen(__DIR__ . '/../../log/' . date("Y-m-d") . '.log', 'a'), $loginfo);
    }

    public static function load_options()
    {
        $database = new Execute;
        $options = $database->read_all('options');
        return [
            'sitename'         => $options[0]['option_value'],
            'get_qid'          => $options[1]['option_value'],
            'enable_reg'       => $options[2]['option_value'],
            'enable_sign_in'   => $options[3]['option_value'],
            'site_url'         => $options[4]['option_value'],
            'session_lifetime' => $options[5]['option_value']
        ];
    }

    public static function load_custom_text()
    {
        $database = new Execute;
        $data = $database->read_all('options');
        for ($i = 0; $i < count($data); $i++) {
            $return[$data[$i]['option_name']] = $data[$i]['option_value'];
        }
        /* 计算开服日期 */
        $startdate = "2022-03-01";
        $now = new DateTime();
        $now_ = $now->format("Y-m-d");
        $return['day'] = (strtotime($now_) - strtotime($startdate)) / 86400;

        return $return;
    }

    public static function get_uid($eml)
    {
        $database = new Execute;

        $result = $database->execute_command(
            "SELECT * FROM `users` WHERE eml=:eml;",
            array(':eml' => $eml)
        );

        /* 检查返回值 */
        if (gettype($result) == 'integer') {
            if ($result == -1) {
                return null;
            }
        }

        return $result['uid'];
    }
}
