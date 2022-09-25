<?php

function register($eml, $passwd, $usrname, $ip, $reg_time, $qq, $submit)
{
    $config = json_decode(file_get_contents("../../conf/mysql.json"), true); 
    $servername = $config['servername'];
    $dbname = $config['dbname'];
    try 
    {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $config['username'], $config['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $command = $conn->prepare("SELECT * FROM usr");  
        $command->execute();
        while($result=$command->fetch(PDO::FETCH_ASSOC)) 
        {
            if ($eml == $result['eml']) 
            {
                echo '邮箱已被占用';
                return false;
            }
        }
        $command = $conn->prepare("INSERT INTO `usr` (`eml`, `passwd`, `usrname`, `ip`, `reg_time`, `qq`, `submit`) 
                                   VALUES (:eml, :passwd, :usrname, :ip, :reg_time, :qq, :submit);"); 
        $command->bindParam(':eml', $eml);
        $command->bindParam(':passwd', $passwd);
        $command->bindParam(':usrname', $usrname);
        $command->bindParam(':ip', $ip);
        $command->bindParam(':reg_time', $reg_time);
        $command->bindParam(':qq', $qq);
        $command->bindParam(':submit', $submit);
        $command->execute();
        echo '注册完成';
    }
    catch(PDOException $e)
    {
        $errinfo = '[' . date("H:i:s") .'] [MySQL/ERROR]: '. $e->getMessage() . "\n";
        @fwrite(fopen('../../log/'.date("Y-m-d").'.log', 'a'), $errinfo);
        echo '注册失败：数据库错误。请报告此问题';
    }
}

function login($eml, $passwd)
{
    $config = json_decode(file_get_contents("../../conf/mysql.json"), true);
    $servername = $config['servername'];
    $dbname = $config['dbname'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $config['username'], $config['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $command = $conn->prepare("SELECT * FROM usr");
        $command->execute();
        while ($result = $command->fetch(PDO::FETCH_ASSOC)) {
            if ($eml == $result['eml']) {
                $command = $conn->prepare("SELECT * FROM usr WHERE eml=?");
                $command->bindParam(1, $result['eml']);
                $command->execute();
                array_filter($result);

                while ($result = $command->fetch(PDO::FETCH_ASSOC)) {
                    if ($passwd == $result['passwd']) {
                        if ($result['qq'] == '0') {
                            return 2;
                        } else {
                            return 3;
                        }
                    } else {
                        return 1;
                    }
                }
            }
        }

        return 0;
    } catch (PDOException $e) {
        $errinfo = '[' . date("H:i:s") . '] [MySQL/ERROR]: ' . $e->getMessage() . "\n";
        @fwrite(fopen('../../log/' . date("Y-m-d") . '.log', 'a'), $errinfo);
        echo '登录失败，数据库错误，请报告此问题';
    }
}
$conn = null;

function save_qid($eml, $qid)
{
    $config = json_decode(file_get_contents("../../conf/mysql.json"), true);
    $servername = $config['servername'];
    $dbname = $config['dbname'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $config['username'], $config['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $command = $conn->prepare("SELECT * FROM usr");
        $command->execute();
        while ($result = $command->fetch(PDO::FETCH_ASSOC)) {
            if ($qid == $result['qq']) {
                echo '-1';
                return false;
            }
        }
        $command = $conn->prepare("UPDATE usr SET qq=:qid WHERE eml=:eml");
        $command->bindParam(':eml', $eml);
        $command->bindParam(':qid', $qid);
        $command->execute();
        echo 'done';
    } catch (PDOException $e) {
        $errinfo = '[' . date("H:i:s") . '] [MySQL/ERROR]: ' . $e->getMessage() . "\n";
        @fwrite(fopen('../../log/' . date("Y-m-d") . '.log', 'a'), $errinfo);
        echo '验证失败：数据库错误。请报告此问题';
    }
}

function getip()
{

    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } 
    

    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");

        
    } else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
        $ip = getenv("REMOTE_ADDR");

    } else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
        $ip = $_SERVER['REMOTE_ADDR'];


    } else {
        $ip = "unknown";
    }

    return $ip;
}
