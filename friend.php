<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-09 19:24:57
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-15 23:18:14
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态
if (!isset($_COOKIE['username'])) {
    location('请先登录再进行本操作！','login.php');
}
//同意添加好友模块
if (@$_GET['action'] == 'agree' && isset($_GET['id'])) {
    //要删除的时候，需要进行唯一标识符验证，避免恶意删除
    if (!!$rows1=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows1['bbs_uniqid'],$_COOKIE['uniqid']);
        //修改表里面的state,来通过验证
        query("UPDATE bbs_friend SET bbs_state=1 WHERE bbs_id='{$_GET['id']}'");
        //判断是否同意成功
        if (affected_rows() ==1) {
            //关闭数据库
            close();
            //跳转到首页
            location('好友同意成功！','friend.php');
        }else{
            //关闭数据库
            close();
            alert('好友同意失败');
        }
    }else{
        alert('非法操作');
    }
}
//批量删除好友
if (@$_GET['action'] == 'delete'&&isset($_POST['ids'])) {
    $clean = array();
    $clean['ids'] = mysql_real_escape_string(implode(',', $_POST['ids']));
    //要删除的时候，需要进行唯一标识符验证，避免恶意删除
    if (!!$rows1=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows1['bbs_uniqid'],$_COOKIE['uniqid']);
        query("DELETE FROM bbs_friend WHERE bbs_id in ({$clean['ids']})");
        //判断是否删除成功
        if (affected_rows()) {
            //关闭数据库
            close();
            //跳转到首页
            location('好友删除成功！','friend.php');
        }else{
            //关闭数据库
            close();
            alert('好友删除失败');
        }
    }else{
        alert('非法操作');
    }
}
//分页模块
global $page_size,$page_num;
//第一个参数：根据什么字段查询数据，第二个参数：设置每页显示多少条数据
pager_param("SELECT bbs_id FROM bbs_friend WHERE (bbs_touser='{$_COOKIE['username']}' OR bbs_fromuser='{$_COOKIE['username']}')",8);
//从数据库提取数据
//每次while循环的数据是读取的结果集，并不是去重新查询数据库
$result = query("SELECT bbs_id,bbs_touser,bbs_fromuser,bbs_content,bbs_state,bbs_date FROM bbs_friend WHERE (bbs_touser='{$_COOKIE['username']}' OR bbs_fromuser='{$_COOKIE['username']}') ORDER BY bbs_date DESC LIMIt $page_num,$page_size");
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
        <div class="main fr">
            <section>
                <h2>会员管理中心</h2>
                <form id="delete" action="friend.php?action=delete" method="post" >
                <table>
                    <thead>
                        <tr>
                            <th width="10%">请求方</th>
                            <th width="15%">被请求方</th>
                            <th width="35%">请求内容</th>
                            <th width="20%">请求时间</th>
                            <th width="10%">状态</th>
                            <th width="10%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $html = array();
                            while ( !!$rows = fetch_array_list($result,MYSQL_ASSOC)) {
                                $html['id'] = $rows['bbs_id'];
                                $html['touser'] = $rows['bbs_touser'];
                                $html['fromuser'] = $rows['bbs_fromuser'];
                                $html['content'] = $rows['bbs_content'];
                                $html['state'] = $rows['bbs_state'];
                                $html['date'] = $rows['bbs_date'];
                                $html = html($html);
                                if ($html['touser'] == $_COOKIE['username']) {
                                    if (empty($html['state'])) {
                                        $html['state_html'] = '<a href="friend.php?action=agree&id='.$html['id'].'" title="" style="color:red;">您未验证</a>';
                                    }else{
                                        $html['state_html'] = '<span style="color:green;">通过</span>';
                                    }
                                }elseif($html['fromuser'] == $_COOKIE['username']){
                                    if (empty($html['state'])) {
                                        $html['state_html'] = '<span style="color:blue;">对方未验证</span>';
                                    }else{
                                        $html['state_html'] = '<span style="color:green;">通过</span>';
                                    }
                                }
                        ?>
                        <tr>
                            <td><?php echo $html['fromuser']; ?></td>
                            <td><?php echo $html['touser']; ?></td>
                            <td title="<?php echo $html['content']; ?>"><?php echo title($html['content'],56); ?></td>
                            <td><?php echo $html['date']; ?></td>
                            <td><?php echo $html['state_html']; ?></td>
                            <td><input type="checkbox" name="ids[]" value="<?php echo $html['id']; ?>"></td>
                        </tr>
                        <?php } 
                            free_result($result);
                        ?>
                        <tr><td colspan="6" ><label for="all"><input id="all" name="checkall" type="checkbox" />全选</label><input type="submit" name="submit" value="删除选中私信"></td></tr>
                    </tbody>
                </table>
                </form>
                <?php //pager参数：t表示文本式分页，n表数字分页
                    pager('t'); ?>
             </section>
        </div>
    </div>
    <script src="js/show_message.js"></script>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>
