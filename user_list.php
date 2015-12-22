<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-18 20:26:45
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-21 22:56:27
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//管理员才能登录进来
admin_login();
//删除模块
if (@$_GET['action'] == 'delete'&&isset($_GET['id'])) {
    //要删除的时候，需要进行唯一标识符验证，避免恶意删除
    if (!!$rows1=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows1['bbs_uniqid'],$_COOKIE['uniqid']);
        query("DELETE FROM bbs_users WHERE bbs_id='{$_GET['id']}'");
        //判断是否删除成功
        if (affected_rows()) {
            //关闭数据库
            close();
            //跳转到首页
            location('删除用户成功！','user_list.php');
        }else{
            //关闭数据库
            close();
            alert('删除失败');
        }
    }else{
        alert('非法操作');
    }
}
//分页模块
global $page_size,$page_num;
//第一个参数：根据什么字段查询数据，第二个参数：设置每页显示多少条数据
pager_param("SELECT bbs_id FROM bbs_users",10);
//从数据库提取数据
//每次while循环的数据是读取的结果集，并不是去重新查询数据库
$result = query("SELECT bbs_id,bbs_username,bbs_reg_time,bbs_email,bbs_active,bbs_last_time,bbs_last_ip FROM bbs_users ORDER BY bbs_reg_time DESC LIMIt $page_num,$page_size");
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
                <h2>会员列表中心</h2>
                <form action="user_list.php?action=" method="post">
                    <table>
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="10%">会员名</th>
                                <th width="20%">邮件</th>
                                <th width="15%">注册时间</th>
                                <th width="10%">激活状态</th>
                                <th width="15%">最后登录时间</th>
                                <th width="10%">登录IP</th>
                                <th width="15%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $html = array();
                                while ( !!$rows = fetch_array_list($result,MYSQL_ASSOC)) {
                                    $html['id'] = $rows['bbs_id'];
                                    $html['username'] = $rows['bbs_username'];
                                    $html['email'] = $rows['bbs_email'];
                                    
                                    $html['reg_time'] = $rows['bbs_reg_time'];
                                    $html['last_time'] = $rows['bbs_last_time'];
                                    $html['last_ip'] = $rows['bbs_last_ip'];
                                    $html = html($html);
                                    if (empty($rows['bbs_active'])) {
                                        $html['active'] = '<span style="color:blue;">激活</span>';
                                    }else{
                                        $html['active'] = '<span style="color:red;">未激活</span>';
                                    }
                            ?>
                            <tr>
                                <td><?php echo $html['id']; ?></td>
                                <td><?php echo $html['username']; ?></td>
                                <td><?php echo $html['email']; ?></td>
                                <td><?php echo $html['reg_time']; ?></td>
                                <td><?php echo $html['active']; ?></td>
                                <td><?php echo $html['last_time']; ?></td>
                                <td><?php echo $html['last_ip']; ?></td>
                                <td><a class="delete" href="user_list.php?action=delete&id=<?php echo $html['id']; ?>"  title="">删除</a><a class="modify"  href="admin_modify.php?id=<?php echo $html['id']; ?>" >修改</a></td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                </form>
                <?php free_result($result);
                    //pager参数：t表示文本式分页，n表数字分页
                    pager('t');
                ?>
        </div>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>