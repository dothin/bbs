<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-08 23:59:57
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-20 21:24:18
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态
if (!isset($_COOKIE['username'])) {
    location('请先登录再进行本操作！','login.php');
}
//删除私信模块
if (@$_GET['action'] == 'delete' && isset($_GET['id'])) {
    //验证私信时候合法
    if(!!$rows = fetch_array("SELECT bbs_id FROM bbs_message WHERE bbs_id='{$_GET['id']}' LIMIT 1")){
        //要删除的时候，需要进行唯一标识符验证，避免恶意删除
        if (!!$rows1=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
            //为了防止cookie伪造，要比对一下唯一标识符uniqid
            uniqid_check($rows1['bbs_uniqid'],$_COOKIE['uniqid']);
            //删除单条短信
            query("DELETE FROM bbs_message WHERE bbs_id='{$_GET['id']}' LIMIT 1");
            //判断是否删除成功
            if (affected_rows() ==1) {
                //关闭数据库
                close();
                //跳转到首页
                location('恭私信删除成功！','message_detail.php');
            }else{
                //关闭数据库
                close();
                alert('删除失败');
            }
        }else{
            alert('非法操作');
        }
    }else{
        alert('此私信不存在');
    }
}
//根据id查询私信内容
if (isset($_GET['id'])) {
    //获取数据
    $rows = fetch_array("SELECT bbs_id,bbs_fromuser,bbs_content,bbs_state,bbs_date FROM bbs_message WHERE bbs_id='{$_GET['id']}' LIMIT 1");
    if ($rows) {
        //如果状态为空（0），就将状态设置为已读（1）
        if (empty($rows['bbs_state'])) {
            query("UPDATE bbs_message SET bbs_state=1 WHERE bbs_id='{$_GET['id']}' LIMIT 1");
            if (!affected_rows()) {
                alert('私信状态异常');
            }
        }
        $html = array();
        $html['id'] = $rows['bbs_id'];
        $html['fromuser'] = $rows['bbs_fromuser'];
        $html['content'] = $rows['bbs_content'];
        $html['date'] = $rows['bbs_date'];
        $html = html($html);
    }else{
        location(null,'message_detail.php');
    }
}else{
    location(null,'message.php');
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
        <?php require ROOT_PATH.'includes/userzone.inc.php'; ?>
        <div class="main fr message-detail">
                <h2>短信详情中心</h2>
                <dl>
                    <dt>发信人</dt>
                    <dd><?php echo $html['fromuser']; ?></dd>
                    <dt>内容</dt>
                    <dd><?php echo $html['content']; ?></dd>
                    <dt>发信时间</dt>
                    <dd><?php echo $html['date']; ?></dd>
                    <dt>操作</dt>
                    <dd><input id="back" type="button" name="" value="返回"><input id="delete" type="button" name="<?php echo $html['id']; ?>" value="删除" ></dd>
                </dl>
        </div>
    </div>
    <script src="js/message_detail.js"></script>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>