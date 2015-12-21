<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-19 12:51:29
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-20 21:27:10
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//删除图片
if (@$_GET['action'] =='delete' && isset($_GET['id'])) {
    //为防止恶意注册，跨站攻击
    if (!!$rows=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows['bbs_uniqid'],$_COOKIE['uniqid']);
        //取得这张图片的发布者
        if (!!$rows=fetch_array("SELECT bbs_username,bbs_url,bbs_id,bbs_sid FROM bbs_photo WHERE bbs_id='{$_GET['id']}' LIMIt 1")) {
            //判断删除图片的身份时候合法
            if ($rows['bbs_username']==@$_COOKIE['username'] ||isset($_SESSION['admin'])){
                $html=array();
                $html['id'] = $rows['bbs_id'];
                $html['sid'] = $rows['bbs_sid'];
                $html['username'] = $rows['bbs_username'];
                $html['url'] = $rows['bbs_url'];;
                $html = html($html);
                //先删除数据库信息
                query("DELETE FROM bbs_photo WHERE bbs_id='{$html['id']}'");
                if (affected_rows() ==1) {
                    //删除数据库信息成功才删除磁盘信息
                    if (file_exists($html['url'])) {
                        unlink($html['url']);
                    }else{
                        alert('磁盘里已不存在此图！');
                    }
                    close();
                    location('删除成功！','show_photo.php?id='.$html['sid']);
                }else{
                    close();
                    alert('删除失败');
                }
                
            }else{
                alert('非法操作');
            }
        }else{
            alert('不存在此图片');
        }
    }else{
        alert('非法操作');
    }
}
//判断id是否存在,取值
if (isset($_GET['id'])) {
    if (!!$rows=fetch_array("SELECT bbs_id,bbs_name,bbs_type FROM bbs_photo_dir WHERE bbs_id='{$_GET['id']}' LIMIt 1")) {
        $dirhtml = array();
        $dirhtml['id']=$rows['bbs_id'];
        $dirhtml['name']=$rows['bbs_name'];
        $dirhtml['type']=$rows['bbs_type'];
        $dirhtml=html($dirhtml);
        //对比加密相册的验证信息
        if (@$_POST['password']) {
            if (!!$rows=fetch_array("SELECT bbs_id FROM bbs_photo_dir WHERE bbs_password='".sha1($_POST['password'])."' LIMIt 1")) {
                //生成cookie之后重定向，解决cookie延迟问题
                setcookie('photo'.$dirhtml['id'],$dirhtml['name']);
                location(null,'show_photo.php?id='.$dirhtml['id']);
            }else{
                alert('密码错误');
            }
        }
    }else{
        alert('不存在此相册');
    }
}else{
    alert('非法操作');
}

$percent=0.3;
//分页模块
global $page_size,$page_num,$system,$id;
$id='id='.$dirhtml['id'].'&';
//第一个参数：根据什么字段查询数据，第二个参数：设置每页显示多少条数据
pager_param("SELECT bbs_id FROM bbs_photo WHERE bbs_sid='{$dirhtml['id']}'",$system['photo_num']);
//从数据库提取数据
//每次while循环的数据是读取的结果集，并不是去重新查询数据库
$result = query("SELECT bbs_id,bbs_username,bbs_name,bbs_url,bbs_readcount,bbs_commentcount FROM bbs_photo WHERE bbs_sid='{$dirhtml['id']}' ORDER BY bbs_date DESC LIMIt $page_num,$page_size");
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
        <h2><?php echo $dirhtml['name']; ?></h2>
        <?php 
            if (empty($dirhtml['type'])||@$_COOKIE['photo'.$dirhtml['id']]==$dirhtml['name']||isset($_SESSION['admin'])) {
                $html = array();
                while ( !!$rows = fetch_array_list($result,MYSQL_ASSOC)) {
                    $html['id'] = $rows['bbs_id'];
                    $html['username'] = $rows['bbs_username'];
                    $html['name'] = $rows['bbs_name'];
                    $html['url'] = $rows['bbs_url'];
                    $html['readcount']=$rows['bbs_readcount'];
                    $html['commentcount']=$rows['bbs_commentcount'];
                    $html = html($html);
        ?>
        <figure>
            <a href="photo_detail.php?id=<?php echo $html['id']; ?>" title=""><img src="thumb.php?filename=<?php echo $html['url']; ?>&percent=<?php echo $percent; ?>" alt=""></a>
            <figcaption>
                <a href="photo_detail.php?id=<?php echo $html['id']; ?>" title=""><h3>图片名称：<?php echo $html['name']; ?></h3></a>
                <span>阅读量：<?php echo $html['readcount']; ?></span>
                <span>评论数：<?php echo $html['commentcount']; ?></span>
                <span>上传者：<?php echo $html['username']; ?></span>
                <?php if ($html['username']==@$_COOKIE['username'] ||isset($_SESSION['admin'])){ ?>
                    <a href="show_photo.php?action=delete&id=<?php echo $html['id']; ?>" title="">[删除]</a>
                <?php } ?>
            </figcaption>
        </figure>
        <?php } 
            free_result($result);
            //pager参数：t表示文本式分页，n表数字分页
            pager('t');
        }else{
            echo '<form action="show_photo.php?id='.$dirhtml['id'].'" method="post" >';
            echo '<input type="password" name="password" value="" placeholder="输入密码">';
            echo '<input type="submit" name="" class="btn-blue" value="确认">';
            echo '</form>';
        }
        ?>
            <a href="add_photo.php?id=<?php echo $dirhtml['id']; ?>" title="">上传图片</a>
    </div>
    
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>