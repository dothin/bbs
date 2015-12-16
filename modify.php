<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-07 14:43:31
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-15 23:29:24
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//修改资料
if (@$_GET['action'] == 'modify') {
    //为防止恶意注册，跨站攻击
    check_code($_POST['code'],$_SESSION['code']);
    if (!!$rows=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows['bbs_uniqid'],$_COOKIE['uniqid']);
        //引入验证文件
        include ROOT_PATH.'includes/check.func.php';
        //创建空数组，用来存放提交的合法数据
        $clean = array();
        $clean['password'] = check_modify_password($_POST['password'],6);
        $clean['sex'] = check_sex($_POST['sex']);
        $clean['photo'] = check_photo($_POST['photo']);
        $clean['email'] = check_email($_POST['email'],6,40);
        $clean['qq'] = check_qq($_POST['qq']);
        $clean['url'] = check_url($_POST['url'],40);
        $clean['switch'] = $_POST['switch'];
        $clean['signature'] = check_signature($_POST['signature'],200);
        //修改资料
        if (empty($clean['password'])) {
           query("UPDATE bbs_users SET 
                        bbs_sex='{$clean['sex']}',
                        bbs_photo='{$clean['photo']}',
                        bbs_email='{$clean['email']}',
                        bbs_qq='{$clean['qq']}',
                        bbs_url='{$clean['url']}',
                        bbs_switch='{$clean['switch']}',
                        bbs_signature='{$clean['signature']}'
                    WHERE
                        bbs_username='{$_COOKIE['username']}'
                ");
        }else{
            query("UPDATE bbs_users SET 
                        bbs_password='{$clean['password']}',
                        bbs_sex='{$clean['sex']}',
                        bbs_photo='{$clean['photo']}',
                        bbs_email='{$clean['email']}',
                        bbs_qq='{$clean['qq']}',
                        bbs_url='{$clean['url']}',
                        bbs_switch='{$clean['switch']}',
                        bbs_signature='{$clean['signature']}'
                    WHERE
                        bbs_username='{$_COOKIE['username']}'
                ");
        }
        //可以生成新的唯一标识符，这样更安全
    }
    
    //判断是否修改成功
    //当什么都是不修改时，影响条数为0
    if (affected_rows() >=0) {
        //关闭数据库
        close();
        //清除session
        //session_destroy();
        //跳转到首页
        location('恭喜您修改成功！','userzone.php');
    }else{
        //关闭数据库
        close();
        //session_destroy();
        //跳转到首页
        location('修改失败','modify.php');
    }
}
//是否登录状态
if (isset($_COOKIE['username'])) {
    //获取数据
    $rows = fetch_array("SELECT bbs_username,bbs_sex,bbs_photo,bbs_email,bbs_url,bbs_qq,bbs_switch,bbs_signature FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}'");
    //判断用户是否存在
    if ($rows) {
        $html = array();
        $html['username'] = $rows['bbs_username'];
        $html['sex'] = $rows['bbs_sex'];
        $html['photo'] = $rows['bbs_photo'];
        $html['email'] = $rows['bbs_email'];
        $html['url'] = $rows['bbs_url'];
        $html['qq'] = $rows['bbs_qq'];
        $html['switch'] = $rows['bbs_switch'];
        $html['signature'] = $rows['bbs_signature'];
        $html = html($html);
        //性别
        if ($html['sex'] == '男') {
            $html['sex_html'] = '<label for="man" class="radio"><input type="radio" id="man" name="sex" value="男" checked >男 </label>
                            <label for="woman" class="radio"><input type="radio" id="woman" name="sex" value="女" >女</label>';
        }else{
            $html['sex_html'] = '<label for="man" class="radio"><input type="radio" id="man" name="sex" value="男" >男 </label>
                            <label for="woman" class="radio"><input type="radio" id="woman" name="sex" value="女" checked >女</label>';
        }
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
        <div class="main fr">
            <section>
                <h2>会员管理中心</h2>
                <form class="form-horizontal"  method="post" name="modify" action="?action=modify">
                    <div class="form-groups">
                        <label class="form-labels" for="" >用户名：</label>
                        <div class="controls">
                            <input type="text" name="username" value="<?php echo $html['username']; ?>"> (*必填，至少两位)
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >密码：</label>
                        <div class="controls">
                            <input type="password" name="password"> (留空格不修改)
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >性别：</label>
                        <div class="controls">
                            <?php echo $html['sex_html'];?>
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >头像：</label>
                        <div class="controls relative">
                            <input type="hidden" name="photo" value="<?php echo $html['photo']; ?>" >
                            <img id="photo" src="<?php echo $html['photo']; ?>" alt="头像选择" >
                            <a id="selectPhoto" href="javascript:;" title="换头像">点我切换</a>
                            <div id="photos" class="photos hide">
                                <a id="close"  href="javascript:;" title="close">X</a>
                                <h3 class="h50 lh50">请选择头像</h3>
                                <ul class="inline">
                                    <li><a href="javascript:;"><img src="" alt="" /></a></li>
                                    <li><a href="javascript:;"><img src="" alt="" /></a></li>
                                    <li><a href="javascript:;"><img src="" alt="" /></a></li>
                                    <li><a href="javascript:;"><img src="" alt="" /></a></li>
                                    <li><a href="javascript:;"><img src="" alt="" /></a></li>
                                    <li><a href="javascript:;"><img src="" alt="" /></a></li>
                                    <li><a href="javascript:;"><img src="" alt="" /></a></li>
                                    <li><a href="javascript:;"><img src="" alt="" /></a></li>
                                    <li><a href="javascript:;"><img src="" alt="" /></a></li>
                                    <li><a href="javascript:;"><img src="" alt="" /></a></li>
                                    <li><a href="javascript:;"><img src="" alt="" /></a></li>
                                    <li><a href="javascript:;"><img src="" alt="" /></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >电子邮件：</label>
                        <div class="controls">
                            <input type="text" name="email" value="<?php echo $html['email']; ?>"> (*必填，激活账户)
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >QQ：</label>
                        <div class="controls">
                            <input type="text" name="qq" value="<?php echo $html['qq']; ?>">
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >主页地址：</label>
                        <div class="controls">
                            <input type="text" name="url" value="<?php echo $html['url']; ?>" >
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >个性签名：</label>
                        <div class="controls" id="switch">
                            <input type="hidden" name="" value="<?php echo $html['switch']; ?>">
                            <label for="enable" class="radio"><input type="radio" id="enable" name="switch" value="1" >启用 </label>
                            <label for="disable" class="radio"><input type="radio" id="disable" name="switch" value="0" checked>禁用</label>
                        </div>
                        <script>
                            var oSwitch = document.getElementById('switch');
                            var switchVal = oSwitch.children[0].value;
                            if (switchVal == 1) {
                                document.getElementById('enable').checked = true;
                            };
                        </script>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >签名内容：</label>
                        <div class="controls">
                            <textarea name="signature" cols="26" rows="5"><?php echo $html['signature'];?></textarea>
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >验证码：</label>
                        <div class="controls">
                            <input type="text" name="code" class="code"  > <img src="code.php" id="code"><a id="refreshCode" href="javascript:;" title="看不清">看不清？</a>
                        </div>
                    </div>
                    <div class="form-groups"><input type="submit" class="btn-blue" value="保存" ></div>
                </form>
            </section>
        </div>
    </div>
    <script src="js/modify.js"></script>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>