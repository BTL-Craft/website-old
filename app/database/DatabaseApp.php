<?php
class DatabaseApp
{
    function register($eml, $passwd, $usrname, $ip, $reg_time, $qq, $submit)
    {
        $database = new Execute;

        $result = $database->execute_command(
            "SELECT * FROM usr WHERE eml=:eml",
            array(':eml' => $eml)
        );

        /* 检查返回值*/
        if (gettype($result) == 'integer') {
            if ($result == -1) {
                return -1;
            }
        }

        if (@$result['eml'] == $eml) {
            echo '邮箱已被占用';
            return false;
        } else {
            $token = sha1((string)time(). (string)rand(1000,9999));
            $result = $database->execute_command(
                "INSERT INTO `usr` (`eml`, `passwd`, `usrname`, `ip`, `reg_time`, `qq`, `submit`, `remember_token`) 
                VALUES (:eml, :passwd, :usrname, :ip, :reg_time, :qq, :submit, :remember_token);
                ",
                array(
                    ':eml'      => $eml,
                    ':passwd'   => $passwd,
                    ':usrname'  => $usrname,
                    ':ip'       => $ip,
                    ':reg_time' => $reg_time,
                    ':qq'       => $qq,
                    ':submit'   => $submit,
                    ':remember_token' => $token
                )
            );
            if (gettype($result) == 'integer') {
                if ($result == -1) {
                    return -1;
                }
            }

            /* 注册完成，保存会话 */
            $config = json_decode(
                file_get_contents(__DIR__."/../../conf/main.json"),
                true
            );
            session_name($config['session_name']);
            session_start();
            $_SESSION['token'] = $token;
            echo '注册完成';
        }
    }

    function login($eml, $passwd)
    {
        $database = new Execute;

        $result = $database->execute_command(
            "SELECT * FROM usr WHERE eml=:eml;",
            array(':eml' => $eml)
        );

        /* 检查返回值 */
        if (gettype($result) == 'integer') {
            if ($result == -1) {
                echo '登录失败，数据库错误，请报告此问题';
                return -1;
            }
        }

        /* 检查用户是否存在（输入值与查询结果是否匹配） */
        if ($eml != $result['eml']) {
            echo '用户不存在';
            return 0;
        }

        /* 检查密码 */
        if ($passwd == $result['passwd']) {
            if ($result['qq'] == '0') {//检查QQ
                echo 'QQ未绑定';
                return 2;
            } else {
                $_SESSION['login'] = true;
                $_SESSION['uid'] = $result['uid'];
                echo '登录成功';
                return 3;
            }
        } else {
            echo '密码错误';
            return 1;
        }
    }

    function save_qid($eml, $qid)
    {
        $database = new Execute;
        $result = $database->execute_command(
            "SELECT * FROM usr WHERE eml=:eml",
            array(
                ':eml' => $eml
            )
        );

        /* 检查返回值*/
        if (gettype($result) == 'integer') {
            if ($result == -1) {
                echo '验证失败，数据库错误，请报告此问题';
                return -1;
            }
        }

        /* 检查QQ是否已经占用 */
/*         $result = $database->execute_command(
            "SELECT * FROM usr WHERE qq=:qq",
            array(
                ':qq' => $qid
            )
        );
        if ($qid == $result['qq']) {
            echo '-1';
            return false;
        } */

        /* 保存QQ号到数据库 */
        $result = $database->execute_command(
            "UPDATE usr SET qq=:qid WHERE eml=:eml",
            array(
                ':eml' => $eml,
                ':qid' => $qid
            )
        );

        /* 检查返回值*/
        if (gettype($result) == 'integer') {
            if ($result == -1) {
                echo '验证失败，数据库错误，请报告此问题';
                return -1;
            }
        }
        echo '1';
    }

    function clear()
    {
        $database = new Execute;

        $result = $database->execute_command(
            "TRUNCATE TABLE usr",
            null
        );

        /* 检查返回值*/
        if (gettype($result) == 'integer') {
            if ($result == -1) {
                echo '数据库错误！请查看日志文件';
                return -1;
            }
        }

        $loginfo = '[' . date("H:i:s") . '] [MySQL/INFO]: Cleared table: usr' . "\n";
        fwrite(fopen(__DIR__ . '/../../log/' . date("Y-m-d") . '.log', 'a'), $loginfo);
    }

    function load_options()
    {
        $database = new Execute;
        $options = $database->read_all('options');
        return [
            'get_qid'        => $options[0]['value'],
            'enable_reg'     => $options[1]['value'],
            'enable_sign_in' => $options[2]['value'],
            'nontbot_host'   => $options[3]['value'],
            'site_url'       => $options[4]['value'],
            'enable_sign_in' => $options[5]['value']
        ];
    }

    function load_custom_text()
    {
        $database = new Execute;
        $data = $database->read_all('custom_texts');
        for ($i = 0; $i < count($data); $i++) {
            $return[$data[$i]['key']] = $data[$i]['value'];
        }
        return $return;
    }
}
