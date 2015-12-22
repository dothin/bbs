<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-19 16:29:50
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-22 13:32:28
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);
session_start();
//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//评论
if (@$_GET['action'] == 'rephoto') {
    //为防止恶意注册，跨站攻击
    if ($system['code']==1) {
        check_code($_POST['code'],$_SESSION['code']);
     }
     if (!!$rows=fetch_array("SELECT bbs_uniqid FROM bbs_users WHERE bbs_username='{$_COOKIE['username']}' LIMIt 1")) {
        //为了防止cookie伪造，要比对一下唯一标识符uniqid
        uniqid_check($rows['bbs_uniqid'],$_COOKIE['uniqid']);
        //接收数据
        $clean = array();
        //可以通过唯一标识符来防止恶意注册，伪装表单跨站攻击等。
        //唯一标识符第二个作用，登录cookie验证
        $clean['fid'] =mysql_real_escape_string($_POST['fid']);
        $clean['username'] =mysql_real_escape_string($_COOKIE['username']);
        $clean['title'] =mysql_real_escape_string($_POST['title']);
        $clean['content'] =mysql_real_escape_string($_POST['content']);
        //写入数据库
        query("INSERT INTO bbs_photo_comment (
                                        bbs_fid,
                                        bbs_username,
                                        bbs_title,
                                        bbs_content,
                                        bbs_date
                                        )
                                VALUES(
                                        '{$clean['fid']}',
                                        '{$clean['username']}',
                                        '{$clean['title']}',
                                        '{$clean['content']}',
                                        NOW()
                                        )
        ");

        if (affected_rows() ==1) {
            //累积评论
            query("UPDATE bbs_photo SET bbs_commentcount=bbs_commentcount+1 WHERE  bbs_id='{$clean['fid']}'");
            //关闭数据库
            close();
            //清除session
            //session_destroy();
            //跳转到首页
            location('恭喜您评论成功！','photo_detail.php?id='.$clean['fid']);
        }else{
            //关闭数据库
            close();
            //session_destroy();
            //跳转到首页
            alert('评论失败');
        }
    }else{
        alert('非法登录');
    }
}
//判断id是否存在，取值
if (isset($_GET['id'])) {
    if (!!$rows=fetch_array("SELECT bbs_id,bbs_name,bbs_url,bbs_username,bbs_fid,bbs_content,bbs_readcount,bbs_commentcount,bbs_date FROM bbs_photo WHERE bbs_id='{$_GET['id']}' LIMIt 1")) {
        //防止加密相册图片穿插访问
        //先去的目录
        //再判断这个目录是否是加密的
        //如果是加密的，再判断是否有对应的cookie存在，并且对相应的值
        //管理员不受这个限值
        if (!isset($_SESSION['admin'])) {
            if (!!$dirs=fetch_array("SELECT bbs_type,bbs_id,bbs_name FROM bbs_photo_dir WHERE bbs_id='{$rows['bbs_fid']}'")) {
                if (!empty($dirs['bbs_type']) && @$_COOKIE['photo'.$dirs['bbs_id']] !=$dirs['bbs_name']) {
                    alert('非法操作');
                }
            }else{
                alert('相册目录表出错');
            }
        }
        //累计阅读量
        query("UPDATE bbs_photo SET bbs_readcount=bbs_readcount+1 WHERE bbs_id='{$_GET['id']}'");
        $html = array();
        $html['id']=$rows['bbs_id'];
        $html['fid']=$rows['bbs_fid'];
        $html['name']=$rows['bbs_name'];
        $html['username']=$rows['bbs_username'];
        $html['url']=$rows['bbs_url'];
        $html['readcount']=$rows['bbs_readcount'];
        $html['commentcount']=$rows['bbs_commentcount'];
        $html['content']=$rows['bbs_content'];
        $html['date']=$rows['bbs_date'];
        $html=html($html);

        //读取评论
        //分页模块
        global $page_size,$page_num,$page,$id;
        $id='id='.$html['id'].'&';
        //第一个参数：根据什么字段查询数据，第二个参数：设置每页显示多少条数据
        pager_param("SELECT bbs_id FROM bbs_photo_comment WHERE bbs_fid='{$html['id']}'",8);
        //从数据库提取数据
        //每次while循环的数据是读取的结果集，并不是去重新查询数据库
        $result = query("SELECT bbs_username,bbs_title,bbs_content,bbs_date FROM bbs_photo_comment WHERE bbs_fid='{$html['id']}' ORDER BY bbs_date ASC LIMIt $page_num,$page_size");
        //上一页，取得比自己大的ID中最小的那个
        $html['preid']=fetch_array("SELECT min(bbs_id) AS id FROM bbs_photo WHERE bbs_fid='{$html['fid']}' AND bbs_id>'{$html['id']}' LIMIt 1");
        if (!empty($html['preid']['id'])) {
            $html['preid_html']='<a href="photo_detail.php?id='.$html['preid']['id'].'" title="">上一页</a>';
        }else{
            $html['preid_html']='<span>上一页</span>';
        }
        //下一页，取得比自己小的ID中最大的那个
        $html['nextid']=fetch_array("SELECT max(bbs_id) AS id FROM bbs_photo WHERE bbs_fid='{$html['fid']}' AND bbs_id<'{$html['id']}' LIMIt 1");
        if (!empty($html['nextid']['id'])) {
            $html['nextid_html']='<a href="photo_detail.php?id='.$html['nextid']['id'].'" title="">下一页</a>';
        }else{
            $html['nextid_html']='<span>下一页</span>';
        }
    }else{
        alert('不存在此图片');
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
    <div class="container blog clear">
        <h2>图片详情</h2>
        <figure><img src="<?php echo $html['url']; ?>" alt="">
            <figcaption>
                <h3>图片名称：<?php echo $html['name']; ?></h3>
                <span>阅读量：<?php echo $html['readcount']; ?></span>
                <span>评论数：<?php echo $html['commentcount']; ?></span>
                <p>上传者：<?php echo $html['username']; ?>发表于：<?php echo $html['date']; ?></p>
                <p>图片简介：<?php echo $html['content']; ?></p>
            </figcaption>
        </figure>
       <a href="show_photo.php?id=<?php echo $html['fid']; ?>" title="">返回</a>
       <?php echo $html['preid_html']; ?>
        <?php echo $html['nextid_html']; ?>
    </div>
    <div class="container">
        <h2 class="ddd">评论情况</h2>
        <?php 
            //pager参数：t表示文本式分页，n表数字分页
            pager('t');
            $i=1;
            while ( !!$rows = fetch_array_list($result,MYSQL_ASSOC)) {
                $html['username'] = $rows['bbs_username'];
                $html['title'] = $rows['bbs_title'];
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
            }else{

            }
        ?>
        <section class="clear">
            <aside class="fl w340 mr10">
                    <h2>回帖用户</h2>
                    <figure>
                        <img src="<?php echo $html['photo']; ?>" alt="">
                        <figcaption>
                                <h3 class="hide"><?php echo $html['username']; ?></h3>
                                <h3><?php echo $html['username']; ?></h3>
                            
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
                        <span  class="fr"><?php echo ($page-1)*$page_size+$i; ?>#</span><?php echo $html['username']; ?>|发表于：<?php echo $html['date']; ?>
                        <a href="javascript:;" name="re" title="回复<?php echo ($page-1)*$page_size+$i; ?>楼的<?php echo $html['username']; ?>">[回复]</a>
                    </header>
                    <section>
                        <h3><?php echo $html['title']; ?></h3>
                        <p>
                            <?php echo ubb($html['content']); ?> 
                        </p>
                        
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
            </div>
        </section>
        <?php 
                $i++;
            }
            free_result($result);
            //pager参数：t表示文本式分页，n表数字分页
            pager('t');
        ?>

    </div>
    <hr>
    <?php if (isset($_COOKIE['username'])) {?>
    <section id="re">
        <form class="form-horizontal" method="post" name="post" action="?action=rephoto">
            <input type="hidden" name="fid" value="<?php echo $html['id']; ?>">
            <div class="form-groups">
                <label class="form-labels" for="type1" >标题：</label>
                <div class="controls">
                    <input type="text" name="title" value="<?php echo $html['name']; ?>"
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
    </section>
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
    <?php } ?>
    <script src="js/post.js"></script>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>