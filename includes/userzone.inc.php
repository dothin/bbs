<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-07 13:39:29
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-20 21:28:03
 */
//防止恶意调用
if (!defined('IN_TG')) {
    exit('Access Defined!');
}
?>
<aside class="side-bar fl">
        <h2>中心导航</h2>
        <dl>
            <dt>账号管理</dt>
            <dd><a href="userzone.php">个人信息</a></dd>
            <dd><a href="modify.php">修改资料</a></dd>
        </dl>
        <dl>
            <dt>其他管理</dt>
            <dd><a href="message.php">私信查询</a></dd>
            <dd><a href="friend.php">好友设置</a></dd>
            <dd><a href="flower.php">查询花朵</a></dd>
            <dd><a href="">个人相册</a></dd>
        </dl>
</aside>