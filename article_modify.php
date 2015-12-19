<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-15 16:40:03
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-19 20:35:35
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
//修改数据,也需要判断权限
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
        //可以通过唯一标识符来防止恶意注册，伪装表单跨站攻击等。
        //唯一标识符第二个作用，登录cookie验证
        $clean['id'] =mysql_real_escape_string($_POST['id']);
        $clean['username'] =mysql_real_escape_string($_COOKIE['username']);
        $clean['type'] =mysql_real_escape_string($_POST['type']);
        $clean['title'] =mysql_real_escape_string(check_post_title($_POST['title'],2,40));
        $clean['content'] =mysql_real_escape_string(check_post_content($_POST['content'],10));
        //写入数据库
        query("UPDATE bbs_article SET 
                                    bbs_title='{$clean['title']}',
                                    bbs_type='{$clean['type']}',
                                    bbs_content='{$clean['content']}',
                                    bbs_last_modify_date=NOW()
                                WHERE bbs_id='{$clean['id']}'
        ");

        if (affected_rows() ==1) {
            //关闭数据库
            close();
            //清除session
            //session_destroy();
            //跳转到首页
            location('恭喜您修改成功！','article.php?id='.$clean['id']);
        }else{
            //关闭数据库
            close();
            //session_destroy();
            //跳转到首页
            alert('修改失败');
        }
    }else{
        alert('非法登录');
    }
}
//读取数据
if (isset($_GET['id'])) {
    //判断主题帖子是否存在,回帖不算
    if (!!$rows = fetch_array("SELECT bbs_username,bbs_title,bbs_type,bbs_content FROM bbs_article WHERE bbs_reid=0 AND bbs_id='{$_GET['id']}'")) {
        $html = array();
        $html['id']=$_GET['id'];
        $html['username'] = $rows['bbs_username'];
        $html['title'] = $rows['bbs_title'];
        $html['type'] = $rows['bbs_type'];
        $html['content'] = $rows['bbs_content'];
        $html = html($html);

        //判断修改权限
        if (!isset($_SESSION['admin'])) {
            if ($_COOKIE['username'] != $html['username']) {
                alert('您没有权限修改这个主题');
            }
        }
        
    }else{
        alert('不存在这个主题');
    }
}else{
    alert('非法操作');
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
        <form class="form-horizontal" method="post" name="post" action="?action=modify">
            <input type="hidden" name="id" value="<?php echo $html['id'];?>">
            <div class="form-groups">
                <label class="form-labels" for="type1" >类型：</label>
                <div class="controls" style="width:350px;" id="type">  
                    <input type="hidden" name="" value="<?php echo $html['type'];?>">
                    <label for="type1"><input id="type1" type="radio" name="type" value="1" checked>类型一</label>
                    <label for="type2"><input id="type2" type="radio" name="type" value="2">类型二</label>
                    <label for="type3"><input id="type3" type="radio" name="type" value="3">类型三</label>
                    <label for="type4"><input id="type4" type="radio" name="type" value="4">类型四</label>
                    <label for="type5"><input id="type5" type="radio" name="type" value="5">类型五</label>
                    <label for="type6"><input id="type6" type="radio" name="type" value="6">类型六</label>
                    <label for="type7"><input id="type7" type="radio" name="type" value="7">类型七</label>
                    <label for="type8"><input id="type8" type="radio" name="type" value="8">类型八</label>
                    <script>
                        var oType = document.getElementById('type');
                        var typeVal = oType.children[0].value;
                        for (var i = 0; i < oType.getElementsByTagName('label').length; i++) {
                            if (oType.getElementsByTagName('label')[i].children[0].value == typeVal) {
                                oType.getElementsByTagName('label')[i].children[0].checked = true;
                            };
                        };
                    </script>
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="type1" >标题：</label>
                <div class="controls">
                    <input type="text" name="title" value="<?php echo $html['title'];?>"> (*必填，2到40位)
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
                    <textarea name="content" cols="46" rows="10"><?php echo $html['content'];?></textarea>
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >验证码：</label>
                <div class="controls" >
                    <input type="text" name="code" class="code"  >
                    <img src="code.php" id="code">
                    <a id="refreshCode" style="display:inline-block" href="javascript:" title="看不清">看不清？</a>
                </div>
            </div>
            <div class="form-groups">
                <input type="submit" class="btn-blue" value="修改帖子" >
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