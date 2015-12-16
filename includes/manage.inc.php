<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-15 23:38:43
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-15 23:39:24
 */
//防止恶意调用
if (!defined('IN_TG')) {
    exit('Access Defined!');
}
?>
<aside class="side-bar fl">
    <section>
        <h2>管理导航</h2>
        <dl>
            <dt>系统管理</dt>
            <dd><a href="manage.php">后台首页</a></dd>
            <dd><a href="manage_set.php">系统设置</a></dd>
        </dl>
    </section>
</aside>