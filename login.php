<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-06 15:19:49
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-15 23:34:21
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态
login_state();
//处理登录数据
if (@$_GET['action'] == 'login') {
     //为防止恶意注册，跨站攻击
    check_code($_POST['code'],$_SESSION['code']);
    //引入验证文件
    include ROOT_PATH.'includes/login.func.php';

    //接收数据
    $clean = array();
    $clean['username'] = check_username($_POST['username'],2,20);
    $clean['password'] = check_password($_POST['password'],6);
    $clean['time'] = check_time($_POST['time']);
    //数据库验证
    if (!!$rows = fetch_array("SELECT bbs_username,bbs_uniqid,bbs_level FROM bbs_users WHERE bbs_username='{$clean['username']}' AND bbs_password='{$clean['password']}' AND bbs_active='' LIMIT 1")) {
        //登录成功后记录登录信息
        query("UPDATE bbs_users SET bbs_last_time=NOW(),bbs_last_ip='{$_SERVER["REMOTE_ADDR"]}',bbs_login_count=bbs_login_count+1 WHERE
                        bbs_username='{$rows['bbs_username']}'");
        //session_destroy();
        setcookies($rows['bbs_username'],$rows['bbs_uniqid'],$clean['time']);
        //管理员生成session
        if ($rows['bbs_level'] == 1) {
            $_SESSION['admin']=$rows['bbs_username'];
        }
        close();
        location(null,'userzone.php');
    }else{
        close();
        //session_destroy();
        location('用户名或密码不正确或者该账户未被激活！','login.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div class="container mt10 ddd login">
        <form class="form-horizontal" method="post" name="login" action="login.php?action=login">
            <div class="form-groups">
                <label class="form-labels" for="" >用户名：</label>
                <div class="controls">
                    <input type="text" name="username"> (*必填，至少两位)
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >密码：</label>
                <div class="controls">
                    <input type="password" name="password"> (*必填，至少六位)
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >保留：</label>
                <div class="controls">
                    <label for="none"><input type="radio" id="none" name="time" value="0" checked="checked">不保留</label>
                    <label for="day"><input type="radio" id="day" name="time" value="1" >一天</label>
                    <label for="week"><input type="radio" id="week" name="time" value="2" >一周</label>
                    <label for="month"><input type="radio" id="month" name="time" value="3" >一个月</label>
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >验证码：</label>
                <div class="controls">
                    <input type="text" name="code" class="code"  > <img src="code.php" id="code"><a id="refreshCode" href="javascript:;" title="看不清">看不清？</a>
                </div>
            </div>
            <div class="form-groups"><input type="submit" class="btn-blue" value="登录" ></div>
        </form>
    </div>
    <script src="js/login.js"></script>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>