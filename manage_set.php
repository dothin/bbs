<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-15 23:56:00
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-18 20:10:15
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//管理员才能登录进来
admin_login();
//修改系统表
if (@$_GET['action'] == 'set') {
    if (!!$rows=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows['bbs_uniqid'],$_COOKIE['uniqid']);
        //创建空数组，用来存放提交的合法数据
        $clean = array();
        $clean['webname'] =mysql_real_escape_string($_POST['webname']);
        $clean['article_num'] =mysql_real_escape_string($_POST['article_num']);
        $clean['blog_num'] =mysql_real_escape_string($_POST['blog_num']);
        $clean['photo_num'] =mysql_real_escape_string($_POST['photo_num']);
        $clean['hot_num'] =mysql_real_escape_string($_POST['hot_num']);
        $clean['newuser_num'] =mysql_real_escape_string($_POST['newuser_num']);
        $clean['skin'] =mysql_real_escape_string($_POST['skin']);
        $clean['string'] =mysql_real_escape_string($_POST['string']);
        $clean['post_time'] =mysql_real_escape_string($_POST['post_time']);
        $clean['repost_time'] =mysql_real_escape_string($_POST['repost_time']);
        $clean['code'] =mysql_real_escape_string($_POST['code']);
        $clean['register'] =mysql_real_escape_string($_POST['register']);
        
        //写入数据库
        query("UPDATE bbs_system SET 
                                    bbs_webname='{$clean['webname']}',
                                    bbs_article_num='{$clean['article_num']}',
                                    bbs_blog_num='{$clean['blog_num']}',
                                    bbs_photo_num='{$clean['photo_num']}',
                                    bbs_hot_num='{$clean['hot_num']}',
                                    bbs_newuser_num='{$clean['newuser_num']}',
                                    bbs_skin='{$clean['skin']}',
                                    bbs_string='{$clean['string']}',
                                    bbs_post_time='{$clean['post_time']}',
                                    bbs_repost_time='{$clean['repost_time']}',
                                    bbs_code='{$clean['code']}',
                                    bbs_register='{$clean['register']}',
                                    bbs_last_modify_date=NOW(),
                                    bbs_modify_user='{$_COOKIE['username']}'
                                WHERE
                                    bbs_id=1
                                LIMIT 1
            ");
        if (affected_rows() >=0) {
            //关闭数据库
            close();
            //清除session
            //session_destroy();
            //跳转到首页
            location('恭喜您修改成功！','manage_set.php');
        }else{
            //关闭数据库
            close();
            //session_destroy();
            //跳转到首页
            location('修改失败！','manage_set.php');
        }
    }else{
        aLert('登录异常');
    }
}

//读取系统表
if (!!$rows = fetch_array("SELECT bbs_webname,bbs_article_num,bbs_blog_num,bbs_photo_num,bbs_hot_num,bbs_newuser_num,bbs_skin,bbs_string,bbs_post_time,bbs_repost_time,bbs_code,bbs_register,bbs_last_modify_date,bbs_modify_user FROM bbs_system WHERE  bbs_id=1 LIMIT 1")) {
    $html = array();
    $html['webname']=$rows['bbs_webname'];
    $html['article_num']=$rows['bbs_article_num'];
    $html['blog_num']=$rows['bbs_blog_num'];
    $html['photo_num']=$rows['bbs_photo_num'];
    $html['hot_num']=$rows['bbs_hot_num'];
    $html['newuser_num']=$rows['bbs_newuser_num'];
    $html['skin']=$rows['bbs_skin'];
    $html['string']=$rows['bbs_string'];
    $html['post_time']=$rows['bbs_post_time'];
    $html['repost_time']=$rows['bbs_repost_time'];
    $html['code']=$rows['bbs_code'];
    $html['register']=$rows['bbs_register'];
    $html['last_modify_date']=$rows['bbs_last_modify_date'];
    $html['modify_user']=$rows['bbs_modify_user'];
    $html=html($html);

    if ($html['skin'] == 1) {
        $html['skin_html']='<select style="height:35px;width:220px;" name="skin" >
            <option value="1" selected>第一套皮肤</option>
            <option value="2">第二套皮肤</option>
            <option value="3">第三套皮肤</option>
        </select>';
    }elseif($html['skin'] == 2){
        $html['skin_html']='<select style="height:35px;width:220px;" name="skin" >
            <option value="1" >第一套皮肤</option>
            <option value="2" selected>第二套皮肤</option>
            <option value="3" >第三套皮肤</option>
        </select>';
    }elseif($html['skin'] == 3){
        $html['skin_html']='<select style="height:35px;width:220px;" name="skin" >
            <option value="1" >第一套皮肤</option>
            <option value="2" >第二套皮肤</option>
            <option value="3" selected>第三套皮肤</option>
        </select>';
    }
    if ($html['post_time'] == 30) {
        $html['post_time_html']='<label for="post1"><input id="post1" type="radio" name="post_time" value="30" checked>30秒</label><label for="post2"><input id="post2" type="radio" name="post_time" value="60">一分钟</label><label for="post3"><input id="post3" type="radio" name="post_time" value="180">三分钟</label>';
    }elseif($html['post_time'] == 60){
        $html['post_time_html']='<label for="post1"><input id="post1" type="radio" name="post_time" value="30">30秒</label><label for="post2"><input id="post2" type="radio" name="post_time" value="60" checked>一分钟</label><label for="post3"><input id="post3" type="radio" name="post_time" value="180">三分钟</label>';
    }elseif($html['post_time'] == 180){
        $html['post_time_html']='<label for="post1"><input id="post1" type="radio" name="post_time" value="30">30秒</label><label for="post2"><input id="post2" type="radio" name="post_time" value="60">一分钟</label><label for="post3"><input id="post3" type="radio" name="post_time" value="180" checked>三分钟</label>';
    }
    if ($html['repost_time'] == 15) {
        $html['repost_time_html']='<label for="repost1"><input id="repost1" type="radio" name="repost_time" value="15" checked>15秒</label><label for="repost2"><input id="repost2" type="radio" name="repost_time" value="30">30秒</label><label for="repost3"><input id="repost3" type="radio" name="repost_time" value="60">一分钟</label>';
    }elseif($html['repost_time'] == 30){
        $html['repost_time_html']='<label for="repost1"><input id="repost1" type="radio" name="repost_time" value="15">15秒</label><label for="repost2"><input id="repost2" type="radio" name="repost_time" value="30" checked>30秒</label><label for="repost3"><input id="repost3" type="radio" name="repost_time" value="60">一分钟</label>';
    }elseif($html['repost_time'] == 60){
        $html['repost_time_html']='<label for="repost1"><input id="repost1" type="radio" name="repost_time" value="15">15秒</label><label for="repost2"><input id="repost2" type="radio" name="repost_time" value="30">30秒</label><label for="repost3"><input id="repost3" type="radio" name="repost_time" value="60" checked>一分钟</label>';
    }
    if ($html['code'] == 0) {
        $html['code_html']='<label for="code2"><input id="code2" type="radio" name="code" value="1">启用</label><label for="code1"><input id="code1" type="radio" name="code" value="0" checked>关闭</label>';
    }elseif($html['code'] == 1){
        $html['code_html']='<label for="code2"><input id="code2" type="radio" name="code" value="1" checked>启用</label><label for="code1"><input id="code1" type="radio" name="code" value="0">关闭</label>';
    }
    if ($html['register'] == 0) {
        $html['register_html']='<label for="register2"><input id="register2" type="radio" name="register" value="1">启用</label><label for="register1"><input id="register1" type="radio" name="register" value="0" checked>关闭</label>';
    }elseif($html['register'] == 1){
        $html['register_html']='<label for="register2"><input id="register2" type="radio" name="register" value="1" checked>启用</label><label for="register1"><input id="register1" type="radio" name="register" value="0">关闭</label>';
    }
}else{
    alert('系统表读取错误，请联系管理员');
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
        <?php require ROOT_PATH.'includes/manage.inc.php'; ?>
        <div class="main fr">
            <section>
                <hgroup>
                    <h2>后台管理中心</h2>
                    <h3>最后修改时间：<?php echo $html['last_modify_date']; ?>,由<?php echo $html['modify_user']; ?>修改</h3>
                </hgroup>
                

                <form class="form-horizontal"  method="post" name="set" action="?action=set">
                    <div class="form-groups">
                        <label class="form-labels" for="" >网站名称：</label>
                        <div class="controls">
                            <input type="text" name="webname" value="<?php echo $html['webname'];?>"> 
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >文章每页分页数：</label>
                        <div class="controls">
                            <input type="text" name="article_num" value="<?php echo $html['article_num']; ?>">
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >博友每页分页数：</label>
                        <div class="controls">
                            <input type="text" name="blog_num" value="<?php echo $html['blog_num']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-groups">
                        <label class="form-labels" for="" >相册每页分页数：</label>
                        <div class="controls">
                            <input type="text" name="photo_num" value="<?php echo $html['photo_num']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-groups">
                        <label class="form-labels" for="" >首页主题排行分页数：</label>
                        <div class="controls">
                            <input type="text" name="hot_num" value="<?php echo $html['hot_num']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-groups">
                        <label class="form-labels" for="" >首页新晋会员分页数：</label>
                        <div class="controls">
                            <input type="text" name="newuser_num" value="<?php echo $html['newuser_num']; ?>">
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >站点默认皮肤：</label>
                        <div class="controls">
                            <?php echo $html['skin_html']; ?>
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >站点敏感字符：</label>
                        <div class="controls">
                            <textarea name="string" cols="26" rows="10"><?php echo $html['string'];?></textarea>
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >发帖间隔时间：</label>
                        <div class="controls">
                            <?php echo $html['post_time_html']; ?>
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >回帖间隔时间：</label>
                        <div class="controls">
                            <?php echo $html['repost_time_html']; ?>
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >是否启用验证码：</label>
                        <div class="controls">
                            <?php echo $html['code_html']; ?>
                        </div>
                    </div>
                    <div class="form-groups">
                        <label class="form-labels" for="" >是否允许注册：</label>
                        <div class="controls">
                            <?php echo $html['register_html']; ?>
                        </div>
                    </div>
                    
                    <div class="form-groups"><input type="submit" class="btn-blue" value="修改设置" ></div>
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