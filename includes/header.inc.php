<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-03 21:22:59
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-21 00:03:50
 */
@session_start();
//防止恶意调用
if (!defined('IN_TG')) {
    exit('Access Defined!');
}
global $system,$u_photo;
?>
<header class="header">
    <div class="container">
        <h1 class="logo"><em class="hide"><?php echo $system['webname']; ?></em></h1>
        <ul class="fr">
            <?php if (isset($_COOKIE['username'])) {
                echo '<li><a href="../userzone.php"><img src="'.$u_photo['photo'].'" alt="">'.$_COOKIE['username'].'</a></li>';
            }else{
                echo '<li><a href="../register.php">注册</a></li>
            <li><a href="../login.php">登录</a></li>';
                } ?>
            <li><a href="message.php" title="查看信息">私信 <?php echo $GLOBALS['message']; ?></a></li>
                
            <?php 
                if (isset($_COOKIE['username']) && isset($_SESSION['admin'])) {
                    echo '<li><a href="manage.php">系统管理</a></li>';
                }
                if (isset($_COOKIE['username'])) {
                echo '<li><a href="../logout.php">退出</a></li>';
            } ?>
        </ul>
    </div>
</header>
<div class="nav">
    <nav class="container">
        <ul class="clear">
            <li><a  class="active" href="../index.php">首页</a></li>
            <li><a href="../blog.php">博友</a></li>
            <li><a href="../photo_dir.php">相册</a></li>
            <li class="relative" id="fenge"><a href="javascript:;">风格</a>
                <ul  style="background:#ddd;width:100px;position:absolute;left:0;top:40px;display:none;" id="ul">
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
        </ul>
    </nav>
</div>