<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-13 22:43:53
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-17 23:10:54
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//登录后才可以发帖
if (!isset($_COOKIE['username'])) {
    location('请先登录','login.php');
}
global $system;
//将帖子写入数据库
if (@$_GET['action'] == 'post') {
    //为防止恶意注册，跨站攻击
    if ($system['code']==1) {
        check_code($_POST['code'],$_SESSION['code']);
     }
    if (!!$rows=fetch_array("SELECT bbs_uniqid,bbs_post_time FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows['bbs_uniqid'],$_COOKIE['uniqid']);
        //限制发帖时间
        global $system;
        limit_time('发帖',time(),$rows['bbs_post_time'],$system['post_time']);
        //引入验证文件
        include ROOT_PATH.'includes/check.func.php';
        
        //创建空数组，用来存放提交的合法数据
        $clean = array();
        //可以通过唯一标识符来防止恶意注册，伪装表单跨站攻击等。
        //唯一标识符第二个作用，登录cookie验证
        $clean['username'] =mysql_real_escape_string($_COOKIE['username']);
        $clean['type'] =mysql_real_escape_string($_POST['type']);
        $clean['title'] =mysql_real_escape_string(check_post_title($_POST['title'],2,40));
        $clean['content'] =mysql_real_escape_string(check_post_content($_POST['content'],10));
        //写入数据库
        query("INSERT INTO bbs_article (
                                        bbs_username,
                                        bbs_title,
                                        bbs_type,
                                        bbs_content,
                                        bbs_date
                                        )
                                VALUES(
                                        '{$clean['username']}',
                                        '{$clean['title']}',
                                        '{$clean['type']}',
                                        '{$clean['content']}',
                                        NOW()
                                        )
        ");

        if (affected_rows() ==1) {
            $clean['id']=mysql_insert_id();
            //间隔时间写在cookie里面容易失效，写在数据库又占用资源
            //setcookie('post_time',time());
            $clean['time']=time();
            query("UPDATE bbs_users SET bbs_post_time='{$clean['time']}' WHERE bbs_username='{$_COOKIE['username']}'");
            //关闭数据库
            close();
            //清除session
            //session_destroy();
            //跳转到首页
            location('恭喜您发帖成功！','article.php?id='.$clean['id']);
        }else{
            //关闭数据库
            close();
            //session_destroy();
            //跳转到首页
            alert('发帖失败');
        }
    }else{
        alert('非法登录');
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

    <div class="container mt10 ddd post">
        <form class="form-horizontal" method="post" name="post" action="?action=post">
            <div class="form-groups">
                <label class="form-labels" for="type1" >类型：</label>
                <div class="controls" style="width:350px;">
                    <label for="type1"><input id="type1" type="radio" name="type" value="1" checked>类型一</label>
                    <label for="type2"><input id="type2" type="radio" name="type" value="2">类型二</label>
                    <label for="type3"><input id="type3" type="radio" name="type" value="3">类型三</label>
                    <label for="type4"><input id="type4" type="radio" name="type" value="4">类型四</label>
                    <label for="type5"><input id="type5" type="radio" name="type" value="5">类型五</label>
                    <label for="type6"><input id="type6" type="radio" name="type" value="6">类型六</label>
                    <label for="type7"><input id="type7" type="radio" name="type" value="7">类型七</label>
                    <label for="type8"><input id="type8" type="radio" name="type" value="8">类型八</label>
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="type1" >标题：</label>
                <div class="controls">
                    <input type="text" name="title"> (*必填，2到40位)
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="type1" >贴图：</label>
                <div class="controls" id="emoji">
                    <a href="javascript:;">贴图一</a>
                    <a href="javascript:;">贴图二</a>
                    <a href="javascript:;">贴图三</a>
                </div>
            </div>
            <div class="form-groups relative">
                <label class="form-labels" for="type1" >内容：</label>
                <div class="controls">
                    <?php include ROOT_PATH.'includes/ubb.inc.php'; ?>
                    <textarea name="content" cols="46" rows="10"></textarea>
                </div>
            </div>
            <div class="form-groups code-groups" data-code="<?php echo $system['code']?>">
                <label class="form-labels" for="" >验证码：</label>
                <div class="controls">
                    <input type="text" name="code" class="code"  > <img src="code.php" id="code"><a id="refreshCode" href="javascript:;" title="看不清">看不清？</a>
                </div>
            </div>
            <div class="form-groups">
                <input type="submit" class="btn-blue" value="发表帖子" >
            </div>
            
        </form>
    </div>
    <div id="emojis" class="emojis hide">
        <a id="close"  href="javascript:;" title="close">X</a>
        <h3 class="h50 lh50">请选择表情</h3>
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
    <script src="js/post.js"></script>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>