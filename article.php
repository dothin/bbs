<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-14 21:11:03
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-22 13:35:08
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
global $system;
//处理精华帖
if (@$_GET['action'] =='nice'&&isset($_GET['id'])&&isset($_GET['b'])) {
    //为防止恶意注册，跨站攻击
    if ($system['code']==1) {
        check_code($_POST['code'],$_SESSION['code']);
     }
    if (!!$rows=fetch_array("SELECT bbs_uniqid,bbs_repost_time FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows['bbs_uniqid'],$_COOKIE['uniqid']);
        //设置精华帖,或者取消精华帖
        query("UPDATE bbs_article SET bbs_nice='{$_GET['b']}' WHERE bbs_id='{$_GET['id']}'");
        if (affected_rows() ==1) {
            //关闭数据库
            close();
            location('设置成功！','article.php?id='.$_GET['id']);
        }else{
            //关闭数据库
            close();
            alert('设置失败');
        }
    }else{
        alert('非法登录');
    }
}
//处理回帖
if (@$_GET['action']=='repost') {
    //为防止恶意注册，跨站攻击
    if ($system['code']==1) {
        check_code($_POST['code'],$_SESSION['code']);
     }
    if (!!$rows=fetch_array("SELECT bbs_uniqid,bbs_repost_time FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows['bbs_uniqid'],$_COOKIE['uniqid']);
        //限制回帖时间
        limit_time('回帖',time(),$rows['bbs_repost_time'],$system['repost_time']);
        //引入验证文件
        include ROOT_PATH.'includes/check.func.php';
        
        //创建空数组，用来存放提交的合法数据
        $clean = array();
        //可以通过唯一标识符来防止恶意注册，伪装表单跨站攻击等。
        //唯一标识符第二个作用，登录cookie验证
        $clean['reid'] =mysql_real_escape_string($_POST['reid']);
        $clean['username'] =mysql_real_escape_string($_COOKIE['username']);
        $clean['type'] =mysql_real_escape_string($_POST['type']);
        $clean['title'] =mysql_real_escape_string(check_post_title($_POST['title'],2,40));
        $clean['content'] =mysql_real_escape_string($_POST['content']);
        //写入数据库
        query("INSERT INTO bbs_article (
                                        bbs_reid,
                                        bbs_username,
                                        bbs_title,
                                        bbs_type,
                                        bbs_content,
                                        bbs_date
                                        )
                                VALUES(
                                        '{$clean['reid']}',
                                        '{$clean['username']}',
                                        '{$clean['title']}',
                                        '{$clean['type']}',
                                        '{$clean['content']}',
                                        NOW()
                                        )
        ");

        if (affected_rows() ==1) {
            //setcookie('article_name',time());
            $clean['time']=time();
            query("UPDATE bbs_users SET bbs_repost_time='{$clean['time']}' WHERE bbs_username='{$_COOKIE['username']}'");
            //累积评论
            query("UPDATE bbs_article SET bbs_commentcount=bbs_commentcount+1 WHERE bbs_reid=0 AND bbs_id='{$clean['reid']}'");
            //关闭数据库
            close();
            //清除session
            //session_destroy();
            //跳转到首页
            location('恭喜您回帖成功！','article.php?id='.$clean['reid']);
        }else{
            //关闭数据库
            close();
            //session_destroy();
            //跳转到首页
            alert('发帖失败');
        }
    }else{
        alert('非法登录');
    }
}
//处理楼中回帖
if (@$_GET['action']=='re_art') {
    if (!!$rows=fetch_array("SELECT bbs_uniqid,bbs_repost_time FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows['bbs_uniqid'],$_COOKIE['uniqid']);
        //限制回帖时间
        limit_time('回复',time(),$rows['bbs_repost_time'],$system['repost_time']);
        //创建空数组，用来存放提交的合法数据
        $clean = array();
        $clean['fid'] =mysql_real_escape_string($_POST['fid']);
        $clean['reid'] =mysql_real_escape_string($_POST['reid']);
        $clean['username'] =mysql_real_escape_string($_COOKIE['username']);
        $clean['content'] =mysql_real_escape_string($_POST['content']);
        //写入数据库
        query("INSERT INTO bbs_re_article (
                                        bbs_fid,
                                        bbs_username,
                                        bbs_content,
                                        bbs_date
                                        )
                                VALUES(
                                        '{$clean['fid']}',
                                        '{$clean['username']}',
                                        '{$clean['content']}',
                                        NOW()
                                        )
        ");

        if (affected_rows() ==1) {
            //setcookie('article_name',time());
            $clean['time']=time();
            query("UPDATE bbs_users SET bbs_repost_time='{$clean['time']}' WHERE bbs_username='{$_COOKIE['username']}'");
            //累积评论
            query("UPDATE bbs_article SET bbs_commentcount=bbs_commentcount+1 WHERE bbs_reid=0 AND bbs_id='{$clean['reid']}'");
            //关闭数据库
            close();
            //清除session
            //session_destroy();
            //跳转到首页
            location('恭喜您回帖成功！','article.php?id='.$clean['reid']);
        }else{
            //关闭数据库
            close();
            //session_destroy();
            //跳转到首页
            alert('发帖失败');
        }
    }else{
        alert('非法登录');
    }
}
//读出数据
if (isset($_GET['id'])) {
    //判断主题帖子是否存在,回帖不算
    if (!!$rows = fetch_array("SELECT bbs_id,bbs_username,bbs_title,bbs_type,bbs_content,bbs_readcount,bbs_commentcount,bbs_nice,bbs_last_modify_date,bbs_date FROM bbs_article WHERE bbs_reid=0 AND bbs_id='{$_GET['id']}'")) {
        //累计阅读量
        query("UPDATE bbs_article SET bbs_readcount=bbs_readcount+1 WHERE bbs_id='{$_GET['id']}'");
        $html = array();
        $html['reid']=$rows['bbs_id'];
        //主题帖发表人$html['username_subject']
        $html['username_subject'] = $rows['bbs_username'];
        $html['title'] = $rows['bbs_title'];
        $html['type'] = $rows['bbs_type'];
        $html['content'] = $rows['bbs_content'];
        $html['readcount'] = $rows['bbs_readcount'];
        $html['commentcount'] = $rows['bbs_commentcount'];
        $html['nice'] = $rows['bbs_nice'];
        $html['last_modify_date'] = $rows['bbs_last_modify_date'];
        $html['date'] = $rows['bbs_date'];


        //拿出用户名去查找用户信息
        if (!!$rows = fetch_array("SELECT bbs_id,bbs_sex,bbs_photo,bbs_email,bbs_url,bbs_switch,bbs_signature FROM bbs_users WHERE bbs_username='{$html['username_subject']}'")) {
            //提取用户信息
            $html['userid']=$rows['bbs_id'];
            $html['sex']=$rows['bbs_sex'];
            $html['photo']=$rows['bbs_photo'];
            $html['email']=$rows['bbs_email'];
            $html['url']=$rows['bbs_url'];
            $html['switch']=$rows['bbs_switch'];
            $html['signature']=$rows['bbs_signature'];
            $html = html($html);

            //创建全局变量，做个带参数的分页
            global $id;
            $id='id='.$html['reid'].'&';
            //主题帖修改
            if ($html['username_subject']==@$_COOKIE['username']|| isset($_SESSION['admin'])) {
                $html['subject_modify']='[<a href="article_modify.php?id='.$html['reid'].'" title="修改">修改</a>]';
            }
            //读取最后修改时间
            if ($html['last_modify_date'] != '0000-00-00 00:00:00') {
                $html['last_modify_date_string'] = '本帖于'.$html['last_modify_date'].'由'.$html['username_subject'].'最后修改过！';
            }
            //回复楼主
            /*if (@$_COOKIE['username']) {
                $html['re']='<a href="javascript:;" name="re" title="回复楼主'.$html['username_subject'].'">[回复]</a>';
            }*/
            //个性签名
            if ($html['switch'] == 1) {
                $html['signature_html'] = '<p>个性签名：'.$html['signature'].'</p>';
            }
            //读取回帖
            //分页模块
            global $page_size,$page_num,$page;
            //第一个参数：根据什么字段查询数据，第二个参数：设置每页显示多少条数据
            pager_param("SELECT bbs_id FROM bbs_article WHERE bbs_reid='{$html['reid']}'",8);
            //从数据库提取数据
            //每次while循环的数据是读取的结果集，并不是去重新查询数据库
            $result = query("SELECT bbs_id,bbs_username,bbs_title,bbs_type,bbs_content,bbs_date FROM bbs_article WHERE bbs_reid='{$html['reid']}' ORDER BY bbs_date ASC LIMIt $page_num,$page_size");
        }else{
            //这个用户已被删除
        };
    }else{
        alert('不存在这个主题');
    }
}else{
    alert('非法操作');
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
    <?php if ($page==1) {?>
    <div class="subject container clear ">
        <?php 
            //浏览量达到200并且评论量达到10为热帖
            if ($html['readcount']>=200&&$html['commentcount']>=10) {
                echo '<h1 style="color:red;">热</h1>';
            }
            if (!empty($html['nice'])) {
                echo '<h1 style="color:red;">精</h1>';
            }
         ?>
        <aside class="fl w340 mr10">
            <h2>楼主</h2>
            <figure>
                <img src="<?php echo $html['photo']; ?>" alt="<?php echo $html['username_subject']; ?>">
                <figcaption>
                    <h3 class="hide"><?php echo $html['username_subject']; ?></h3>
                    <h3><?php echo $html['username_subject']; ?>[楼主]</h3>
                    <em><?php echo $html['sex']; ?></em>
                    <ul>
                        <li><a href="javascript:;" name="message" title="<?php echo $html['userid']; ?>">发私信</a></li>
                        <li><a href="javascript:;" name="friend">加为好友</a></li>
                        <li><a href="javascript:;">写留言</a></li>
                        <li><a href="javascript:;" name="flower">送鲜花</a></li>
                        <li>邮件：<a href="mailto:<?php echo $html['email']; ?>" title=""><?php echo $html['email']; ?></a></li>
                        <li>网址：<a href="<?php echo $html['url']; ?>" title=""><?php echo $html['url']; ?></a></li>
                    </ul>
                </figcaption>
            </figure>
        </aside>
        <div class="fr w650">
            <article>
                <header>
                    <span class="fr">
                    <?php 
                        if (@$_SESSION['admin']) {
                            if (empty($html['nice'])) {
                                echo '<a href="article.php?action=nice&b=1&id='.$html['reid'].'" title="">[设置为精华帖]</a>';
                            }else{
                                echo '<a href="article.php?action=nice&b=0&id='.$html['reid'].'" title="">[取消精华帖]</a>';
                            }
                        }
                     ?>
                    1#</span><?php echo $html['username_subject']; ?>|发表于：<?php echo $html['date']; ?>
                    <?php echo @$html['subject_modify']; ?>
                </header>
                <section>
                    <h3><?php echo $html['title']; ?></h3>
                    <span>类型：<?php echo $html['type']; ?></span>
                    <p>
                        <?php echo ubb($html['content']); ?>   
                    </p>
                </section>
                <footer>
                    <span>阅读量:<mark><?php echo $html['readcount'] ?></mark></span>
                    <span>评论数:<mark><?php echo $html['commentcount'] ?></mark></span>
                    <span><?php echo @$html['last_modify_date_string']; ?></span>
                    <?php echo @$html['signature_html']; ?>
                </footer>
            </article>
        </div>
    </div>
       
    <?php } ?>
    <div class="container">
        <h2 class="ddd">回帖情况</h2>
        <?php 
            //pager参数：t表示文本式分页，n表数字分页
            pager('t');
            $i=2;
            while ( !!$rows = fetch_array_list($result,MYSQL_ASSOC)) {
                $html['id'] = $rows['bbs_id'];
                $html['username'] = $rows['bbs_username'];
                $html['title'] = $rows['bbs_title'];
                $html['type'] = $rows['bbs_type'];
                $html['content'] = $rows['bbs_content'];
                $html['date'] = $rows['bbs_date'];
                $html = html($html);
                
            //拿出用户名去查找用户信息
            if (!!$rows = fetch_array("SELECT bbs_id,bbs_sex,bbs_photo,bbs_email,bbs_url,bbs_switch,bbs_signature FROM bbs_users WHERE bbs_username='{$html['username']}'")) {
                //提取用户信息
                $html['userid']=$rows['bbs_id'];
                $html['sex']=$rows['bbs_sex'];
                $html['photo']=$rows['bbs_photo'];
                $html['email']=$rows['bbs_email'];
                $html['url']=$rows['bbs_url'];
                $html['switch']=$rows['bbs_switch'];
                $html['signature']=$rows['bbs_signature'];
                $html = html($html);
                //楼层信息
                if ($i==2&&$page==1) {
                    if ($html['username'] == $html['username_subject']) {
                        $html['username_html'] =$html['username'].'[楼主]';
                    }else{
                        $html['username_html'] =$html['username'].'[沙发]';
                    }
                    
                }else{
                    $html['username_html'] =$html['username'];
                }
                
            }else{

            }
            //每次while循环的数据是读取的结果集，并不是去重新查询数据库
            $result_re = query("SELECT bbs_username,bbs_content,bbs_date FROM bbs_re_article WHERE bbs_fid='{$html['id']}'");
        ?>
        <section class="clear ">
            <aside class="fl w340 mr10">
                <h2>回帖用户</h2>
                <figure>
                    <img src="<?php echo $html['photo']; ?>" alt="">
                    <figcaption>
                            <h3 class="hide"><?php echo $html['username']; ?></h3>
                            <h3><?php echo $html['username_html']; ?></h3>
                        
                        <em><?php echo $html['sex']; ?></em>
                        <ul>
                            <li><a href="javascript:;" name="message" title="<?php echo $html['userid']; ?>">发私信</a></li>
                            <li><a href="javascript:;" name="friend">加为好友</a></li>
                            <li><a href="javascript:;">写留言</a></li>
                            <li><a href="javascript:;" name="flower">送鲜花</a></li>
                            <li>邮件：<a href="mailto:<?php echo $html['email']; ?>" title=""><?php echo $html['email']; ?></a></li>
                            <li>网址：<a href="<?php echo $html['url']; ?>" title=""><?php echo $html['url']; ?></a></li>
                        </ul>
                    </figcaption>
                </figure>
            </aside>
            <div class="fr w650">
                <article>
                    <header>
                        <span  class="fr"><?php echo ($page-1)*$page_size+$i; ?>#</span><?php echo $html['username_html']; ?>|发表于：<?php echo $html['date']; ?>
                    </header>
                    <section>
                        <h3 data-name="<?php echo $html['username_html']; ?>"><?php echo $html['title']; ?></h3>
                        <span>类型：<?php echo $html['type']; ?></span>
                        <article>
                            <?php echo ubb($html['content']); ?> 
                        </article>
                        <a href="javascript:;" name="re" title="回复<?php echo $html['username']; ?>">[回复]</a>
                    </section>
                    <footer>
                        <?php 
                            //个性签名
                            if ($html['switch'] == 1) {
                                echo '<p>个性签名：'.$html['signature'].'</p>';
                            }
                         ?>
                    </footer>
                </article>
                <article>
                    <?php 
                         //拿id去查回复信息
                        while ( !!$rows = fetch_array_list($result_re,MYSQL_ASSOC)) {
                            //提取用户信息
                            $htmlre['username']=$rows['bbs_username'];
                            $htmlre['content']=$rows['bbs_content'];
                            $htmlre['date']=$rows['bbs_date'];
                            $htmlre = html($htmlre);
                            if ($htmlre['username'] == $html['username_subject']) {
                                $htmlre['username_html'] =$htmlre['username'].'[楼主]';
                            }else{
                                $htmlre['username_html'] =$htmlre['username'];
                            }
                        ?>
                        <section>
                            <h3 data-name="<?php echo $htmlre['username_html']; ?>"><?php echo $htmlre['username_html']; ?></h3>
                            <span>时间：<?php echo $htmlre['date']; ?></span>
                            <article>
                                <?php echo ubb($htmlre['content']); ?> 
                            </article>
                            <a href="javascript:;" name="re" title="回复<?php echo $htmlre['username_html']; ?>">[回复]</a>
                        </section>
                     <?php
                        }
                     ?>
                </article>
                <form class="re_art hide" action="article.php?action=re_art" method="post" >
                    <!-- reid主题id   id回帖id -->
                    <input type="hidden" name="reid" value="<?php echo $html['reid']; ?> ">
                    <input type="hidden" name="fid" value="<?php echo $html['id']; ?> ">
                     <textarea name="content" cols="46" rows="5"></textarea>
                     <input type="submit" class="btn-primary" name="" value="回复">
                 </form>
            </div>
        </section>
        <hr>
        <?php 
                $i++;
            }
            free_result($result);
            //pager参数：t表示文本式分页，n表数字分页
            pager('t');
        ?>
        <script>
            //回复楼中楼
            var aRe = document.getElementsByName('re');
            var aReArt = document.querySelectorAll('.re_art');
            var aLen = aRe.length;
            for (var i = 0; i < aLen; i++) {                
                aRe[i].onclick=function(){
                    for (var i = 0; i < aReArt.length; i++) {
                        aReArt[i].style.display = 'none';
                    };
                    this.parentNode.parentNode.parentNode.getElementsByTagName('form')[0].style.display = 'block';
                    this.parentNode.parentNode.parentNode.getElementsByTagName('form')[0].content.value='@'+this.parentNode.getElementsByTagName('h3')[0].dataset.name;
                }
            };
            /*for (var i = 0; i < aLen; i++) {
                aRe[i].onclick = function(){
                    if (document.getElementById('ubb') == null) {
                        alert('请先登录再进行回复');
                        return false;
                    };
                    this.href='#re';
                    document.getElementsByName('post')[0].title.value = this.title;
                }
            };*/
        </script>
        <hr>
        <?php if (isset($_COOKIE['username'])) {?>
        <div id="re">
            <form class="form-horizontal" method="post" name="post" action="?action=repost">
                <input type="hidden" name="reid" value="<?php echo $html['reid']; ?>">
                <input type="hidden" name="type" value="<?php echo $html['type']; ?>">
                <div class="form-groups">
                    <label class="form-labels" for="type1" >标题：</label>
                    <div class="controls">
                        <input type="text" name="title" value="<?php echo $html['title']; ?>"> 
                    </div>
                </div>
                <div class="form-groups">
                    <label class="form-labels" for="type1" >贴图：</label>
                    <div class="controls" id="emoji">
                        <a href="javascript:;">贴图一</a>
                        <a href="javascript:;">贴图二</a>
                        <a href="javascript:;">贴图三</a>
                    </div>
                </div>
                <div class="form-groups relative">
                    <label class="form-labels" for="type1" >内容：</label>
                    <div class="controls">
                        <?php include ROOT_PATH.'includes/ubb.inc.php'; ?>
                        <textarea name="content" cols="46" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-groups code-groups" data-code="<?php echo $system['code']?>">
                    <label class="form-labels" for="" >验证码：</label>
                    <div class="controls">
                        <input type="text" name="code" class="code"  > <img src="code.php" id="code"><a id="refreshCode" href="javascript:;" title="看不清">看不清？</a>
                    </div>
                </div>
                <div class="form-groups">
                    <input type="submit" class="btn-primary" value="发表帖子" >
                </div>
                
            </form>
        </div>
        <?php } ?>
    </div>
    <div id="message" class="hide">
        <h2 class="ddd"><span id="tips">发送消息给：</span><span id="friend"></span></h2>
        <form class="form-horizontal" method="post" name="message" id="mform" action="blog.php?action=message">
            <div class="form-groups">
                <label class="form-labels" for="" >私信内容：</label>
                <div class="controls">
                    <input type="hidden" name="touser">
                    <textarea name="content" id="" cols="30" rows="10" maxlength="200"></textarea>
                </div>
            </div>
            <div class="form-groups code-groups" data-code="<?php echo $system['code']?>">
                <label class="form-labels" for="" >验证码：</label>
                <div class="controls">
                    <input type="text" name="code" class="code"  > <img src="code.php" id="code"><a id="refreshCode" href="javascript:;" title="看不清">看不清？</a>
                </div>
            </div>
            <div class="form-groups">
                <input type="submit" class="btn-blue" value="发送" >
            </div>
        </form>
    </div>
    <div id="emojis" class="emojis hide">
        <a id="close"  href="javascript:;" title="close">X</a>
        <h3 class="h50 lh50">请选择表情</h3>
        <ul class="inline">
            <li><a href="javascript:;"><img src="" alt="" /></a></li>
            <li><a href="javascript:;"><img src="" alt="" /></a></li>
            <li><a href="javascript:;"><img src="" alt="" /></a></li>
            <li><a href="javascript:;"><img src="" alt="" /></a></li>
            <li><a href="javascript:;"><img src="" alt="" /></a></li>
            <li><a href="javascript:;"><img src="" alt="" /></a></li>
            <li><a href="javascript:;"><img src="" alt="" /></a></li>
            <li><a href="javascript:;"><img src="" alt="" /></a></li>
            <li><a href="javascript:;"><img src="" alt="" /></a></li>
            <li><a href="javascript:;"><img src="" alt="" /></a></li>
            <li><a href="javascript:;"><img src="" alt="" /></a></li>
            <li><a href="javascript:;"><img src="" alt="" /></a></li>
        </ul>
    </div>
    <script src="js/blog.js"></script>
    <script src="js/post.js"></script>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>
