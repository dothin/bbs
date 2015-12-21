<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-07 13:17:42
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-20 21:27:46
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';

if (isset($_COOKIE['username'])) {
    //获取数据
    $rows = fetch_array("SELECT bbs_username,bbs_sex,bbs_photo,bbs_level,bbs_email,bbs_url,bbs_qq,bbs_reg_time FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIT 1");
    //判断用户是否存在
    if ($rows) {
        $html = array();
        $html['username'] = $rows['bbs_username'];
        $html['sex'] = $rows['bbs_sex'];
        $html['photo'] = $rows['bbs_photo'];
        $html['email'] = $rows['bbs_email'];
        $html['url'] = $rows['bbs_url'];
        $html['qq'] = $rows['bbs_qq'];
        $html['reg_time'] = $rows['bbs_reg_time'];
        switch ($rows['bbs_level']) {
            case '0':
                $html['level'] = '普通用户';
                break;
            case '1':
                $html['level'] = '管理员';
                break;
            
            default:
                $html['level'] = '出错';
                break;
        }
        $html = html($html);
    }else{
        alert('该用户不存在');
    }
}else{
    location('请先登录再进行本操作！','login.php');
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
    <div class="container oh uz">
        <?php require ROOT_PATH.'includes/userzone.inc.php'; ?>
        <div class="main fr user">
                <h2>会员管理中心</h2>
                <dl>
                    <dt>用户名</dt>
                    <dd><?php echo $html['username']; ?></dd>
                    <dt>性别</dt>
                    <dd><?php echo $html['sex']; ?></dd>
                    <dt>头像</dt>
                    <dd><img style="height:40px;" src="<?php echo $html['photo']; ?>" alt=""></dd>
                    <dt>电子邮件</dt>
                    <dd><?php echo $html['email']; ?></dd>
                    <dt>QQ</dt>
                    <dd><?php echo $html['qq']; ?></dd>
                    <dt>主页</dt>
                    <dd><?php echo $html['url']; ?></dd>
                    <dt>注册时间</dt>
                    <dd><?php echo $html['reg_time']; ?></dd>
                    <dt>身份</dt>
                    <dd><?php echo $html['level']; ?></dd>
                </dl>
        </div>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>