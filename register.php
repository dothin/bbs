<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-04 15:50:16
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-15 23:29:39
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态
login_state();

//判断是否提交数据
if (@$_GET['action'] == 'register') {
    //为防止恶意注册，跨站攻击
    check_code($_POST['code'],$_SESSION['code']);
    //引入验证文件
    include ROOT_PATH.'includes/check.func.php';
    
    //创建空数组，用来存放提交的合法数据
    $clean = array();
    //可以通过唯一标识符来防止恶意注册，伪装表单跨站攻击等。
    //唯一标识符第二个作用，登录cookie验证
    $clean['uniqid'] = check_uniqid($_POST['uniqid'],$_SESSION['uniqid']);
    //active也是唯一标识符，用来给刚注册的用户做激活处理用，不然也不能登录
    $clean['active'] = sha1_uniqid();
    $clean['username'] =check_username($_POST['username'],2,20) ;
    $clean['password'] = check_password($_POST['password'],$_POST['aginePassword'],6);
    $clean['question'] = check_question($_POST['question'],2,20);
    $clean['answer'] = check_answer($_POST['question'],$_POST['answer'],2,20);
    $clean['sex'] = check_sex($_POST['sex']);
    $clean['photo'] = check_photo($_POST['photo']);
    $clean['email'] = check_email($_POST['email'],6,40);
    $clean['qq'] = check_qq($_POST['qq']);
    $clean['url'] = check_url($_POST['url'],40);
    //新增用户之前，判断用户名是否重复
    is_repeat(
        "SELECT bbs_username FROM bbs_users WHERE  bbs_username='{$clean['username']}' LIMIT 1",
        '对不起，该用户名已被注册'
        );
    //新增用户
    //在双引号里面直接方变量可以$username,但如果是数组，就必须加一个花括号
    query("INSERT INTO bbs_users (
        bbs_uniqid,
        bbs_active,
        bbs_username,
        bbs_password,
        bbs_question,
        bbs_answer,
        bbs_sex,
        bbs_photo,
        bbs_email,
        bbs_qq,
        bbs_url,
        bbs_reg_time,
        bbs_last_time,
        bbs_last_ip
        ) 
    VALUES (
        '{$clean['uniqid']}',
        '{$clean['active']}',
        '{$clean['username']}',
        '{$clean['password']}',
        '{$clean['question']}',
        '{$clean['answer']}',
        '{$clean['sex']}',
        '{$clean['photo']}',
        '{$clean['email']}',
        '{$clean['qq']}',
        '{$clean['url']}',
        NOW(),
        NOW(),
        '{$_SERVER["REMOTE_ADDR"]}'
        )"
    );
    if (affected_rows()==1) {
        //获取刚刚新增的id
        $clean['id']=mysql_insert_id();
        //关闭数据库
        close();
        //清除session
        //session_destroy();
        //生成xml
        set_xml('new.xml',$clean);
        //跳转到首页
        location('恭喜您注册成功！','active.php?active='.$clean['active']);
    }else{
        //关闭数据库
        close();
        //session_destroy();
        //跳转到首页
        location('注册失败','index.php');
    }
    
}
$_SESSION['uniqid'] = $uniqid = sha1_uniqid();

//get_magic_quotes_gpc在 PHP 5.4.O 起将始终返回 FALSE
//echo get_magic_quotes_gpc();
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

    <div class="container mt10 ddd register">
        <form class="form-horizontal" method="post" name="register" action="register.php?action=register">
        <input type="hidden" name="uniqid" value="<?php echo $uniqid;?>" >
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
                <label class="form-labels" for="" >确认密码：</label>
                <div class="controls">
                    <input type="password" name="aginePassword"> (*必填，同上)
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >密码提示：</label>
                <div class="controls">
                    <input type="text" name="question"> (*必填，至少两位)
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >密码回答：</label>
                <div class="controls">
                    <input type="text" name="answer"> (*必填，至少两位)
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >性别：</label>
                <div class="controls">
                    <label for="man" class="radio"><input type="radio" id="man" name="sex" value="男" checked >男 </label>
                    <label for="woman" class="radio"><input type="radio" id="woman" name="sex" value="女" >女</label>
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >头像：</label>
                <div class="controls relative">
                    <input type="hidden" name="photo" value="images/photo/photo (1).jpg" >
                    <img id="photo" src="images/photo/photo (1).jpg" alt="头像选择" >
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
                    <input type="text" name="email"> (*必填，激活账户)
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >QQ：</label>
                <div class="controls">
                    <input type="text" name="qq">
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >主页地址：</label>
                <div class="controls">
                    <input type="text" name="url" value="http://" >
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >验证码：</label>
                <div class="controls">
                    <input type="text" name="code" class="code"  > <img src="code.php" id="code"><a id="refreshCode" href="javascript:;" title="看不清">看不清？</a>
                </div>
            </div>
            <div class="form-groups"><input type="submit" class="btn-blue" value="注册" ></div>
        </form>
    </div>
    <script src="js/register.js"></script>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>