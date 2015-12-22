<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-18 23:03:47
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-22 13:31:14
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//管理员才能登录进来
admin_login();
//添加目录
if (@$_GET['action'] == 'adddir') {
    //要删除的时候，需要进行唯一标识符验证，避免恶意删除
    if (!!$rows1=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows1['bbs_uniqid'],$_COOKIE['uniqid']);
        //引入验证文件
        include ROOT_PATH.'includes/check.func.php';
        //接收数据
        $clean = array();
        $clean['name']=mysql_real_escape_string(check_dir_name($_POST['name'],2,20));
        $clean['type']=mysql_real_escape_string($_POST['type']);
        if (!empty($clean['type'])) {
            $clean['password']=check_dir_password($_POST['password'],6);
        }
        
        $clean['content']=mysql_real_escape_string($_POST['content']);
        $clean['dir']=mysql_real_escape_string(time());
        //检查主目录是否存在
        if (!is_dir('photo')) {
            mkdir('photo',0777);
        }
        //再在主目录里面创建相册目录
        if (!is_dir('photo/'.$clean['dir'])) {
            mkdir('photo/'.$clean['dir']);
            chmod('photo/'.$clean['dir'], 0777);
        }
        //把当前的目录信息写入数据库
        if (empty($clean['type'])) {
            query("INSERT INTO bbs_photo_dir (
                                            bbs_name,
                                            bbs_type,
                                            bbs_content,
                                            bbs_dir,
                                            bbs_date
                                            )
                                    VALUES (
                                            '{$clean['name']}',
                                            '{$clean['type']}',
                                            '{$clean['content']}',
                                            'photo/{$clean['dir']}',
                                            NOW()
                                        )
            ");
        }else{
            query("INSERT INTO bbs_photo_dir (
                                            bbs_name,
                                            bbs_type,
                                            bbs_password,
                                            bbs_content,
                                            bbs_dir,
                                            bbs_date
                                            )
                                    VALUES (
                                            '{$clean['name']}',
                                            '{$clean['type']}',
                                            '{$clean['password']}',
                                            '{$clean['content']}',
                                            'photo/{$clean['dir']}',
                                            NOW()
                                        )
            ");
        }
        if (affected_rows()==1) {
            //关闭数据库
            close();
            location('目录添加成功！','photo_dir.php');
        }else{
            close();
            alert('目录添加失败');
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
        <h2>添加相册</h2>
        <form class="form-horizontal" method="post" name="addphotodir" action="add_photo_dir.php?action=adddir">
            <div class="form-groups">
                <label class="form-labels" for="" >相册名称</label>
                <div class="controls">
                    <input type="text" name="name"> 
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >相册类型：</label>
                <div class="controls">
                    <label for="public" class="radio"><input type="radio" id="public" name="type" value="0" checked >公开 </label>
                    <label for="private" class="radio"><input type="radio" id="private" name="type" value="1" >私密</label>
                </div>
            </div>
            <div class="form-groups hide" id="pass">
                <label class="form-labels" for="" >相册密码：</label>
                <div class="controls">
                    <input type="password" name="password"> 
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >相册描述：</label>
                <div class="controls">
                    <textarea name="content" cols="46" rows="10"></textarea>
                </div>
            </div>
            <div class="form-groups"><input type="submit" class="btn-primary" value="添加目录" ></div>
        </form>
    </div>
    <script src="js/add_photo_dir.js"></script>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>