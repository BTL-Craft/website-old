<?php

namespace App;

use App\Database\DatabaseApp;

class Auth {
    public static function register(
        $eml,
        $passwd,
        $usrname,
        $ip,
        $reg_time,
        $qq,
        $submit
    ) {
        $database = new Execute;

        $result = $database->execute_command(
            "SELECT * FROM `users` WHERE eml=:eml",
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
            $result = $database->execute_command(
                "INSERT INTO ``users`` (`eml`, `passwd`, `usrname`, `ip`, `reg_time`, `qq`, `submit`, `remember_token`) 
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
                    ':remember_token' => null
                )
            );
            if (gettype($result) == 'integer') {
                if ($result == -1) {
                    return -1;
                }
            }

            $_SESSION['eml'] = $eml;
            echo '注册完成';
        }
    }
    /**
     * 普通登录，传入邮箱和密码
     **/
    public static function login($eml, $passwd)
    {
        $config = json_decode(file_get_contents(__DIR__ . '/../../.env.json'), true);
        $database = new Execute;

        $result = $database->execute_command(
            "SELECT * FROM `users` WHERE eml=:eml;",
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
        if (!is_array($result)) {
            echo '用户不存在';
            return 0;
        }

        /* 检查密码 */
        if ($passwd == $result['passwd']) {
            if ($result['qq'] == '0') { //检查QQ
                echo 'QQ未绑定';
                return 2;
            } else {
                /* 将通过后的email发送到皮肤站插件 */
                $f = fopen($config['blessing_skin']['api_plugin_path'].'/email.txt', 'w');
                fwrite($f, $eml);
                fclose($f);

                echo '登录成功';
                return 3;
            }
        } else {
            echo '密码错误';
            return 1;
        }
    }

    public static function save_qid($eml, $qid)
    {
        $database = new Execute;
        $result = $database->execute_command(
            "SELECT * FROM `users` WHERE eml=:eml",
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
        $result = $database->execute_command(
            "SELECT * FROM `users` WHERE qq=:qq",
            array(
                ':qq' => $qid
            )
        );
        if ($qid == $result['qq']) {
            echo '-1';
            return false;
        }

        /* 保存QQ号到数据库 */
        $result = $database->execute_command(
            "UPDATE `users` SET qq=:qid WHERE eml=:eml",
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

    public static function remember($remem)
    {
        $token = password_hash((string)time(), PASSWORD_DEFAULT);
        $database = new Execute;

        $_SESSION['token'] = $token; // token存入session
        $options = DatabaseApp::load_options();
        $lifeTime = $options['session_lifetime'] * 24 * 3600;
        if ($remem == true) {
            setcookie(session_name(), session_id(), time() + $lifeTime, "/");
        } else {
            setcookie(session_name(), session_id(), "/");
        }
        echo '1';
    }

    /**
     * 使用token登录
     **/
    public static function login_by_token($token)
    {
        /*
        |--------------------------------------------------------------------------
        | 使用token登录
        |--------------------------------------------------------------------------
        |
        | $token：保存在session中的token
        | 返回值
        | -1 内部错误
        | [数组]，其中state == 'logoff' token不存在
        | [数组] 其中state == 'logoon'登录成功，返回用户信息
        |
        */
        $database = new Execute;

        $result = $database->execute_command(
            "SELECT * FROM `users` WHERE remember_token=:remember_token;",
            array(':remember_token' => $token)
        );

        /* 检查返回值 */
        if (gettype($result) == 'integer') {
            if ($result == -1) {
                echo '登录失败，数据库错误，请报告此问题';
                return -1;
            }
        }

        /* 检查token是否合法（查询结果是否匹配，不匹配则表示不存在此token） */
        if (is_array($result)) {
            if ($token == $result['remember_token']) {
                return [
                    'eml'     => $result['eml'],
                    'usrname' => $result['usrname'],
                    'qq'      => $result['qq'],
                    'state'   => 'logon'
                ];
            } else {
                return [
                    'state' => 'logoff'
                ];
            }
        } else {
            return [
                'state' => 'logoff'
            ];
        }
    }

    public static function logout()
    {
        if (array_key_exists('token', $_SESSION)) {
            unset($_SESSION['token']);
            return true;
        } else {
            return false;
        }
    }
}