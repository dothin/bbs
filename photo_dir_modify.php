<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-19 00:53:18
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-19 19:07:34
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//管理员才能登录进来
admin_login();
//修改
if (@$_GET['action'] == 'modify') {
    //为防止恶意注册，跨站攻击
    if (!!$rows=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows['bbs_uniqid'],$_COOKIE['uniqid']);
        //引入验证文件
        include ROOT_PATH.'includes/check.func.php';
        
        //创建空数组，用来存放提交的合法数据
        $clean['id']=mysql_real_escape_string($_POST['id']);
        $clean['name']=mysql_real_escape_string(check_dir_name($_POST['name'],2,20));
        $clean['type']=mysql_real_escape_string($_POST['type']);
        if (!empty($clean['type'])) {
            $clean['password']=check_dir_password($_POST['password'],6);
        }
        $clean['cover']=mysql_real_escape_string($_POST['cover']);
        $clean['content']=mysql_real_escape_string($_POST['content']);
        //写入数据库
        if (empty($clean['type'])) {
            query("UPDATE bbs_photo_dir SET bbs_name='{$clean['name']}',
                                            bbs_type='{$clean['type']}',
                                            bbs_password=NULL,
                                            bbs_content='{$clean['content']}',
                                            bbs_cover='{$clean['cover']}'
                                    WHERE bbs_id='{$clean['id']}' ");
        }else{
            query("UPDATE bbs_photo_dir SET bbs_name='{$clean['name']}',
                                            bbs_type='{$clean['type']}',
                                            bbs_password='{$clean['password']}',
                                            bbs_content='{$clean['content']}',
                                            bbs_cover='{$clean['cover']}'
                                    WHERE bbs_id='{$clean['id']}' ");
        }

        if (affected_rows() ==1) {
            //关闭数据库
            close();
            //清除session
            //session_destroy();
            //跳转到首页
            location('恭喜您修改成功！','photo_dir.php');
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
    if (!!$rows = fetch_array("SELECT bbs_id,bbs_name,bbs_type,bbs_content,bbs_cover FROM bbs_photo_dir WHERE bbs_id='{$_GET['id']}' LIMIt 1")) {
        $html = array();
        $html['id']=$_GET['id'];
        $html['name'] = $rows['bbs_name'];
        $html['type'] = $rows['bbs_type'];
        $html['content'] = $rows['bbs_content'];
        $html['cover'] = $rows['bbs_cover'];
        $html = html($html);
    }else{
        alert('不存在这个相册');
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
    <section class="container blog clear">
        <h2>修改相册</h2>
        <form class="form-horizontal" method="post" name="addphoto" action="photo_dir_modify.php?action=modify">
            <input type="hidden" name="id" value="<?php echo $html['id'];?>">
            <div class="form-groups">
                <label class="form-labels" for="" >相册名称：</label>
                <div class="controls">
                    <input type="text" name="name" value="<?php echo $html['name'] ?>"> 
                </div>
            </div>
            <div class="form-groups" >
                <label class="form-labels" for="" >相册类型：</label>
                <div class="controls" id="type">
                    <input type="hidden" name="" value="<?php echo $html['type'];?>">
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
                <label class="form-labels" for="" >相册封面：</label>
                <div class="controls">
                    <input type="text" name="cover" value="<?php echo $html['cover'];?>"> 
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >相册描述：</label>
                <div class="controls">
                    <textarea name="content" cols="46" rows="10"><?php echo $html['content'];?></textarea>
                </div>
            </div>
            <div class="form-groups"><input type="submit" class="btn-blue" value="添加目录" ></div>
        </form>
    </section>
    <script>
        var oType = document.getElementById('type');
        var aType = document.getElementsByName('type');
        var oPu = document.getElementById('public');
        var oPr = document.getElementById('private');
        var oPass = document.getElementById('pass');
        var typeVal = oType.children[0].value;
        if (typeVal==1) {
            oPr.checked=true;
            oPass.style.display='block';
        }else{
            oPu.checked=true;
            oPass.style.display='hide';
        };
        for (var i = 0; i < aType.length; i++) {
        aType[i].onchange = function() {
            if (this.value == 1) {
                oPass.style.display = 'block';
            } else {
                oPass.style.display = 'none';
            };
        }
    };
    </script>
    <script src="js/add_photo_dir.js"></script>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>