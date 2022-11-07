<?php

namespace App\Auth;

use App\Database\DatabaseApp;
use App\Database\Execute;
use Vectorface\Whip\Whip;
use \env;

class Auth
{
    public static function register($eml, $passwd, $usrname)
    {
        $whip = new Whip();
        $ip = $whip->getValidIpAddress();
        $database = new Execute;

        if (env::load('auth', 'single_ip_restrictions') == true) {
            if (DatabaseApp::where('users', 'ip', $ip) != false) {
                echo '请不要重复注册账号';
                return false;
            }
        }


        if (DatabaseApp::where('users', 'eml', $eml) != false) {
            echo '邮箱已被占用';
            return false;
        }

        $result = $database->execute_command(
            "INSERT INTO `users` (`eml`, `passwd`, `usrname`, `ip`, `reg_time`) 
                VALUES (:eml, :passwd, :usrname, :ip, :reg_time);
                ",
            array(
                ':eml'      => $eml,
                ':passwd'   => $passwd,
                ':usrname'  => $usrname,
                ':ip'       => $ip,
                ':reg_time' => date("Y-m-d h:i:s"),
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

    public static function login($eml, $passwd)
    {
        $database = new Execute;

        $result = $database->execute_command(
            "SELECT * FROM `users` WHERE eml=:eml;",
            array(':eml' => $eml)
        );


        if (gettype($result) == 'integer') {
            if ($result == -1) {
                echo '登录失败，数据库错误，请报告此问题';
                return -1;
            }
        }


        if (!is_array($result)) {
            echo '用户不存在';
            return 0;
        }


        if ($passwd == $result['passwd']) {
            if ($result['qq'] == null) {
                echo 'QQ未绑定';
                $_SESSION['eml'] = $eml;
                return 2;
            } else {

                $f = fopen(env::load('blessing_skin', 'api_plugin_path') . '/email.txt', 'w');
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

    public static function save_qid($code)
    {
        if (!array_key_exists('eml', $_SESSION)) {
            echo '请重新登录';
            return;
        }

        $data = json_decode(file_get_contents(env::load('auth', 'nonebot')));

        foreach ($data as $qid => $value) {

            if ($value[0] == $code && $value[1] > time()) {

                if (DatabaseApp::where('users', 'eml', $_SESSION['eml']) == false) {
                    echo '请重新登录';
                    return false;
                }

                if (DatabaseApp::where('users', 'qq', $qid) != false) {
                    echo '-1';
                    return false;
                }

                DatabaseApp::update(
                    'users',
                    array(
                        'key' => 'qq',
                        'value' => $qid
                    ),
                    array(
                        'key' => 'eml',
                        'value' => $_SESSION['eml']
                    )
                );
                echo '1';
                return true;
            }
        }
        echo '无效的验证码';
        return false;
    }

    public static function remember($remem)
    {
        $token = substr(str_shuffle(strtoupper(sha1(time())) . sha1(time() + 201)), 0, 40);
        $encryptMethod = env::load('session', 'encryptMethod');
        $ivLength = openssl_cipher_iv_length($encryptMethod);
        $iv = openssl_random_pseudo_bytes($ivLength, $isStrong);
        if (false === $iv && false === $isStrong) {
            die('服务器内部错误：错误代码：02。请报告此问题');
        }
        $encrypted = openssl_encrypt($token, $encryptMethod, 'secret', 0, $iv);
        $_SESSION['token'] = $token;
        $options = DatabaseApp::load_options();
        $lifeTime = $options['session_lifetime'] * 24 * 3600;
        if ($remem == true) {
            setcookie(session_name(), session_id(), time() + $lifeTime, "/");
        } else {
            setcookie(session_name(), session_id(), "/");
        }
        echo '1';
    }


    public static function login_by_token($token)
    {
        $database = new Execute;

        $result = $database->execute_command(
            "SELECT * FROM `users` WHERE remember_token=:remember_token;",
            array(':remember_token' => $token)
        );


        if (gettype($result) == 'integer') {
            if ($result == -1) {
                echo '登录失败，数据库错误，请报告此问题';
                return -1;
            }
        }


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
