<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-18 22:57:52
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-22 00:12:41
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//删除目录
if (@$_GET['action']=='delete'&&isset($_GET['id'])) {
     //为防止恶意注册，跨站攻击
    if (!!$rows=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows['bbs_uniqid'],$_COOKIE['uniqid']);
        //删除操作
        //取得这个目录的发布信息
        if (!!$rows=fetch_array("SELECT bbs_dir FROM bbs_photo_dir WHERE bbs_id='{$_GET['id']}' LIMIt 1")) {
            $html=array();
            $html['url'] = $rows['bbs_dir'];
            $html = html($html);
            
            //3,删除磁盘目录
            if (file_exists($html['url'])) {
               if (remove_Dir($html['url'])) {
                    //1,删除目录里的数据库图片
                    query("DELETE FROM bbs_photo WHERE bbs_fid='{$_GET['id']}'");
                    //2,删除这个目录的数据库
                    query("DELETE FROM bbs_photo_dir WHERE bbs_id='{$_GET['id']}'");
                    close();
                    location('删除磁盘目录成功！','photo_dir.php');
               }else{
                    close();
                    alert('删除磁盘目录失败');
               }
            }
        }else{
            alert('不存在此目录');
        }
    }else{
        alert('非法操作');
    }
}
//分页模块
global $page_size,$page_num,$system;
//第一个参数：根据什么字段查询数据，第二个参数：设置每页显示多少条数据
pager_param("SELECT bbs_id FROM bbs_photo_dir",$system['photo_num']);
//从数据库提取数据
//每次while循环的数据是读取的结果集，并不是去重新查询数据库
$result = query("SELECT bbs_id,bbs_name,bbs_type,bbs_cover FROM bbs_photo_dir ORDER BY bbs_date DESC LIMIt $page_num,$page_size");
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
        <h2>相册</h2>
        <?php 
            $html = array();
            while ( !!$rows = fetch_array_list($result,MYSQL_ASSOC)) {
                    $html['id'] = $rows['bbs_id'];
                    $html['name'] = $rows['bbs_name'];
                    $html = html($html);
                    if ($rows['bbs_type'] == 1) {
                        $html['type']='私密';
                    }else{
                        $html['type']='公开';
                    }
                    if (empty($rows['bbs_cover'])) {
                        $html['cover']='images/photo/photo (11).jpg';
                    }else{
                        $html['cover'] = $rows['bbs_cover'];
                    }
                    //统计相册中的照片数量
                    $html['photo']=fetch_array("SELECT COUNT(*) AS count FROM bbs_photo WHERE bbs_fid='{$html['id']}'");
            ?>
            <figure>
                <img src="<?php echo $html['cover'] ?>" alt="">
                <figcaption>
                    <h3><a href="show_photo.php?id=<?php echo $html['id'] ?>" title=""><?php echo $html['name'] ?>[<?php echo $html['type'] ?>]</a></h3>
                    <p>总共：<?php echo $html['photo']['count']; ?></p>
                    <?php if (isset($_COOKIE['username']) && isset($_SESSION['admin'])) { ?>
                        <a href="photo_dir_modify.php?id=<?php echo $html['id'] ?>" title="">修改</a>
                        <a href="photo_dir.php?action=delete&id=<?php echo $html['id']; ?>" title="">删除</a>
                    <?php } ?>
                    
                </figcaption>
            </figure>
         <?php } 
            free_result($result);
            //pager参数：t表示文本式分页，n表数字分页
            pager('t');
        ?>
        
        <?php if (isset($_COOKIE['username']) && isset($_SESSION['admin'])) { ?>
            <a href="add_photo_dir.php" title="">添加目录</a>
        <?php } ?>
    </div>
    
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>