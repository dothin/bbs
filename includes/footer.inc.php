<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-03 21:24:15
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-05 22:32:15
 */
//防止恶意调用
if (!defined('IN_TG')) {
    exit('Access Defined!');
}
//关闭数据库
close();
?>
<footer class="footer h150 mt20 tc">
    <p>该页面执行总共耗时：<mark><?php echo round((runtime()-TIME_START),4); ?></mark></p>
</footer>