<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-03 21:22:59
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-19 20:54:48
 */
@session_start();
//防止恶意调用
if (!defined('IN_TG')) {
    exit('Access Defined!');
}
global $system;
?>
<header class="container h150 header">
    <h1><?php echo $system['webname']; ?></h1>
    <nav>
        <ul class="tr">
            <li><a href="../index.php">首页</a></li>
            
            <?php if (isset($_COOKIE['username'])) {
                echo '<li><a href="../userzone.php">'.$_COOKIE['username'].'的'.'个人中心</a></li>';
            }else{
                echo '<li><a href="../register.php">注册</a></li>
            <li><a href="../login.php">登录</a></li>';
                } ?>
            <li><a href="../blog.php">博友</a></li>
            <li><a href="../photo_dir.php">相册</a></li>
            <li class="relative" id="fenge"><a href="javascript:;">风格</a>
                <ul  style="background:#ddd;position:absolute;left:0;top:40px;display:none;" id="ul">
                    <li><a href="skin.php?id=1" title="">风格1</a></li>
                    <li><a href="skin.php?id=2" title="">风格2</a></li>
                    <li><a href="skin.php?id=3" title="">风格3</a></li>
                </ul>
            </li>
            <script>
                window.onload = function(){
                    var oFenge=document.getElementById('fenge');
                    var oUl=document.getElementById('ul');
                    oFenge.onclick = function(){
                        oUl.style.display = 'block';
                    }
                }
            </script>
            <li><a href="message.php" title="查看信息">私信 <?php echo $GLOBALS['message']; ?></a></li>
            
            <?php 
                if (isset($_COOKIE['username']) && isset($_SESSION['admin'])) {
                    echo '<li><a href="manage.php">管理</a></li>';
                }
                if (isset($_COOKIE['username'])) {
                echo '<li><a href="../logout.php">退出</a></li>';
            } ?>
        </ul>
    </nav>
</header>