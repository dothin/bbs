<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-06 16:54:05
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-22 13:31:36
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态
if (!isset($_COOKIE['username'])) {
    location('请先登录再进行本操作！','login.php');
}
//分页模块
global $page_size,$page_num,$system;
//第一个参数：根据什么字段查询数据，第二个参数：设置每页显示多少条数据
pager_param("SELECT bbs_id FROM bbs_users",$system['blog_num']);
//从数据库提取数据
//每次while循环的数据是读取的结果集，并不是去重新查询数据库
$result = query("SELECT bbs_id,bbs_username,bbs_sex,bbs_photo FROM bbs_users ORDER BY bbs_reg_time DESC LIMIt $page_num,$page_size");
//发私信
if (@$_GET['action'] == 'message') {
    if ($system['code']==1) {
        check_code($_POST['code'],$_SESSION['code']);
     }
    if (!!$rows=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows['bbs_uniqid'],$_COOKIE['uniqid']);
        //引入验证文件
        include ROOT_PATH.'includes/check.func.php';
        $clean = array();
        $clean['touser'] = mysql_real_escape_string($_POST['touser']);
        $clean['fromuser'] = mysql_real_escape_string($_COOKIE['username']);
        $clean['content'] = mysql_real_escape_string(check_content($_POST['content'],1,200));
        //写入数据库
        query("INSERT INTO bbs_message (
                            bbs_touser,
                            bbs_fromuser,
                            bbs_content,
                            bbs_date
                            )
                    VALUES (
                            '{$clean['touser']}',
                            '{$clean['fromuser']}',
                            '{$clean['content']}',
                            NOW()
                            )
        ");
        if (affected_rows()==1) {
            //关闭数据库
            close();
            //清除session
            //session_destroy();
            //跳转到首页
            alert('私信成功！');
        }else{
            //关闭数据库
            close();
            //session_destroy();
            //跳转到首页
            alert('私信失败');
        }
    }else{
        alert('非法操作');
    }
}
//加好友
if (@$_GET['action'] == 'friend') {
    if ($system['code']==1) {
        check_code($_POST['code'],$_SESSION['code']);
     }
    if (!!$rows=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows['bbs_uniqid'],$_COOKIE['uniqid']);
        //引入验证文件
        include ROOT_PATH.'includes/check.func.php';
        $clean = array();
        $clean['touser'] = mysql_real_escape_string($_POST['touser']);
        $clean['fromuser'] = mysql_real_escape_string($_COOKIE['username']);
        $clean['content'] = mysql_real_escape_string(check_content($_POST['content'],1,200));
        //不能添加自己
        if ($clean['touser'] == $clean['fromuser']) {
            alert('不能添加自己为好友');
        }
        // 验证数据库是否已经添加好友了
        if (!!$rows1=fetch_array("SELECT bbs_id FROM bbs_friend WHERE (bbs_touser='{$clean['touser']}' AND bbs_fromuser='{$clean['fromuser']}') OR (bbs_touser='{$clean['fromuser']}' AND bbs_fromuser='{$clean['touser']}') LIMIt 1")){
            alert('你们已经是好友了或者该好友正在验证您的信息，无需重复添加');
        }else{
            //写入数据库
            query("INSERT INTO bbs_friend (
                                bbs_touser,
                                bbs_fromuser,
                                bbs_content,
                                bbs_date
                                )
                        VALUES (
                                '{$clean['touser']}',
                                '{$clean['fromuser']}',
                                '{$clean['content']}',
                                NOW()
                                )
            ");
            if (affected_rows()==1) {
                //关闭数据库
                close();
                //清除session
                session_destroy();
                //跳转到首页
                alert('添加好友成功，请等待对方同意添加');
            }else{
                //关闭数据库
                close();
                session_destroy();
                //跳转到首页
                alert('添加好友失败');
            }
        }
    }else{
        alert('非法操作');
    }
}
//送鲜花
if (@$_GET['action'] == 'flower') {
    if ($system['code']==1) {
        check_code($_POST['code'],$_SESSION['code']);
     }
    if (!!$rows=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows['bbs_uniqid'],$_COOKIE['uniqid']);
        //引入验证文件
        include ROOT_PATH.'includes/check.func.php';
        $clean = array();
        $clean['touser'] = mysql_real_escape_string($_POST['touser']);
        $clean['fromuser'] = mysql_real_escape_string($_COOKIE['username']);
        $clean['flower'] = mysql_real_escape_string($_POST['flower']);
        $clean['content'] = mysql_real_escape_string(check_content($_POST['content'],1,200));
        
        //写入数据库
        query("INSERT INTO bbs_flower (
                            bbs_touser,
                            bbs_fromuser,
                            bbs_flower,
                            bbs_content,
                            bbs_date
                            )
                    VALUES (
                            '{$clean['touser']}',
                            '{$clean['fromuser']}',
                            '{$clean['flower']}',
                            '{$clean['content']}',
                            NOW()
                            )
        ");
        if (affected_rows()==1) {
            //关闭数据库
            close();
            //清除session
            session_destroy();
            //跳转到首页
            alert('送鲜花成功');
        }else{
            //关闭数据库
            close();
            session_destroy();
            //跳转到首页
            alert('送鲜花失败');
        }
    }else{
        alert('非法操作');
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
    <div class="container blog clear">
        <h2>博友</h2>
        <?php 
            $html = array();
            while ( !!$rows = fetch_array_list($result,MYSQL_ASSOC)) {
                $html['id'] = $rows['bbs_id'];
                $html['username'] = $rows['bbs_username'];
                $html['photo'] = $rows['bbs_photo'];
                $html['sex'] = $rows['bbs_sex'];
                $html = html($html);
        ?>
        <figure>
            <img src="<?php echo $html['photo']; ?>" alt="">
            <figcaption>
                <h3><?php echo $html['username']; ?></h3>
                <em><?php echo $html['sex']; ?></em>
                <ul>
                    <li><a href="javascript:;" name="message" title="<?php echo $html['id']; ?>">发私信</a></li>
                    <li><a href="javascript:;" name="friend">加为好友</a></li>
                    <li><a href="javascript:;">写留言</a></li>
                    <li><a href="javascript:;" name="flower">送鲜花</a></li>
                </ul>
            </figcaption>
        </figure>
        
        
        <?php } 
            free_result($result);
            //pager参数：t表示文本式分页，n表数字分页
            pager('t');
        ?>
        
    </div>
    <div id="message" class="hide">
            <h2 class="ddd"><span id="tips">发送消息给：</span><span id="friend"></span></h2>
            <form class="form-horizontal" method="post" name="message" id="mform" action="blog.php?action=message">
                <div class="form-groups">
                    <label class="form-labels" for="" >私信内容：</label>
                    <div class="controls">
                        <input type="hidden" name="touser">
                        <textarea name="content" id="" cols="30" rows="10" maxlength="200"></textarea>
                    </div>
                </div>
                <div class="form-groups code-groups" data-code="<?php echo $system['code']?>">
                    <label class="form-labels" for="" >验证码：</label>
                    <div class="controls">
                        <input type="text" name="code" class="code"  > <img src="code.php" id="code"><a id="refreshCode" href="javascript:;" title="看不清">看不清？</a>
                    </div>
                </div>
                <div class="form-groups">
                    <input type="submit" class="btn-primary" value="发送" >
                </div>
            </form>
        </div>
    <script src="js/blog.js"></script>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>