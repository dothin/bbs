<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-19 13:02:52
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-19 15:55:33
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//登录用户才能操作
if (!$_COOKIE['username']) {
    alert('非法登录');
}
//判断id是否存在
if (isset($_GET['id'])) {
    if (!!$rows=fetch_array("SELECT bbs_id,bbs_dir FROM bbs_photo_dir WHERE bbs_id='{$_GET['id']}' LIMIt 1")) {
        $html = array();
        $html['id']=$rows['bbs_id'];
        $html['dir']=$rows['bbs_dir'];
        $html=html($html);
    }else{
        alert('不存在此相册');
    }
}else{
    alert('非法操作');
}
//执行上传图片功能
if (@$_GET['action']=='upload') {
    //要删除的时候，需要进行唯一标识符验证，避免恶意删除
    if (!!$rows1=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows1['bbs_uniqid'],$_COOKIE['uniqid']);
        //上传图片
        //上传类型
        $file_type = array('image/jpeg','image/pjpeg','image/gif','image/x-png','image/png');
        //判断是否是允许上传的类型
        if (@is_array($fileType)) {
            if (!in_array($_FILES['userfile']['type'], $fileType)) {
                alert('本站只允许jpp,png,gif文件');
            }
        }
        //判断文件如果出错的错误类型
        if ($_FILES['userfile']['error']>0) {
            switch ($_FILES['userfile']['error']) {
                case '1':
                    alert('上传文件超过约定值');
                    break;
                case '2':
                    alert('上传文件超过约定值');
                    break;
                case '3':
                    alert('部分被上传');
                    break;
                case '4':
                    alert('没有任何文件上传');
                    break;
            }
            exit;
        }
        //判断配置大小
        if ($_FILES['userfile']['size']>1000000) {
           alert('上传文件超过1M');
        }

        //获取文件扩展名
        $n=explode('.', $_FILES['userfile']['name']);
        $name = $_POST['dir'].'/'.time().'.'.$n[1];
        //移动文件
        if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
            //echo "上传的临时文件已找到";
            if(!@move_uploaded_file($_FILES['userfile']['tmp_name'],$name )){
                alert('移动失败');
            }else{
                location('上传成功','add_photo.php?id='.$html['id'].'&name='.$name);
            }

        }else{
            alert('文件上传失败,上传的临时文件不存在');
        }
    }else{
        alert('非法操作');
    }
}
//保存图片信息进入数据库
if (@$_GET['action']=='addphoto') {
    //要删除的时候，需要进行唯一标识符验证，避免恶意删除
    if (!!$rows1=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows1['bbs_uniqid'],$_COOKIE['uniqid']);
        //引入验证文件
        include ROOT_PATH.'includes/check.func.php';
        //接收数据
        $clean = array();
        $clean['name']=mysql_real_escape_string(check_dir_name($_POST['name'],2,20));
        $clean['url']=mysql_real_escape_string(check_photo_url($_POST['url']));
        $clean['content']=mysql_real_escape_string($_POST['content']);
        $clean['sid']=mysql_real_escape_string($_POST['sid']);

        //写入数据库
        query("INSERT INTO bbs_photo (
                                    bbs_name,
                                    bbs_url,
                                    bbs_content,
                                    bbs_sid,
                                    bbs_username,
                                    bbs_date
                                    )
                            VALUES (
                                    '{$clean['name']}',
                                    '{$clean['url']}',
                                    '{$clean['content']}',
                                    '{$clean['sid']}',
                                    '{$_COOKIE['username']}',
                                    NOW()
                                )
            ");
        if (affected_rows()==1) {
            //关闭数据库
            close();
            location('图片添加成功！','show_photo.php?id='.$clean['sid']);
        }else{
            close();
            alert('图片添加失败');
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
    <section class="container blog clear">
        <h2>上传图片</h2>
        <form class="form-horizontal" method="post" name="addphotodir" action="add_photo.php?action=addphoto&id=<?php echo $html['id']; ?>">
            <input type="hidden" name="sid" value="<?php echo $html['id']; ?>">
            <div class="form-groups">
                <label class="form-labels" for="" >图片名称</label>
                <div class="controls">
                    <input type="text" name="name"> 
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >图片地址：</label>
                <div class="controls">
                    <input type="text" readonly="readonly" name="url" value="<?php echo @$_GET['name']; ?>"> <a id="addphoto"  href="javascript:;" title="">上传</a>
                </div>
            </div>
            <div class="form-groups">
                <label class="form-labels" for="" >图片描述：</label>
                <div class="controls">
                    <textarea name="content" cols="46" rows="10"></textarea>
                </div>
            </div>
            <div class="form-groups"><input type="submit" class="btn-blue" value="上传图片" ></div>
        </form>
    </section>
    <div id="addphotos" class="photos hide">
        <a id="close"  href="javascript:;" title="close">X</a>
        <h3 class="h50 lh50">上传图片</h3>
        <form action="add_photo.php?action=upload" method="post" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FIFLE_SIZE" value="1000000">
            <input type="hidden" name="dir" value="<?php echo $html['dir']; ?>">
            <input type="hidden" name="id" value="<?php echo $html['id']; ?>">
            <input type="file" name="userfile" value="">
            <input type="submit" value="上传">
        </form>
    </div>
    <script src="js/add_photo.js"></script>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>