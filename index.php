<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-03 12:46:14
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-17 23:09:37
 */
//定义一个常量，用来授权调用includes里面的文件
define('IN_TG', true);

//引入公共文件,转换成硬路径，速度更快
require dirname(__FILE__).'/includes/common.inc.php';
//读取xml文件
$html = html(get_xml('new.xml'));

//分页模块
global $page_size,$page_num,$system;
//第一个参数：根据什么字段查询数据，第二个参数：设置每页显示多少条数据
pager_param("SELECT bbs_id FROM bbs_article WHERE bbs_reid=0",$system['article_num']);
//从数据库提取数据
//每次while循环的数据是读取的结果集，并不是去重新查询数据库
$result = query("SELECT bbs_id,bbs_title,bbs_type,bbs_readcount,bbs_commentcount FROM bbs_article WHERE bbs_reid=0 ORDER BY bbs_date DESC LIMIt $page_num,$page_size");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>首页</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div class="container clear mt10 content">
        <aside class="fl w340 mr10">
            <section>
                <h2>新增会员</h2>
                <figure>
                    <img src="<?php echo $html['photo']; ?>" alt="">
                    <figcaption>
                        <h3><?php echo $html['username']; ?></h3>
                        <em><?php echo $html['sex']; ?></em>
                        <ul>
                            <li><a href="javascript:;" name="message" title="<?php echo $html['id']; ?>">发私信</a></li>
                            <li><a href="javascript:;" name="friend">加为好友</a></li>
                            <li><a href="javascript:;">写留言</a></li>
                            <li><a href="javascript:;" name="flower">送鲜花</a></li>
                            <li>邮件：<a href="mailto:<?php echo $html['email']; ?>" title=""><?php echo $html['email']; ?></a></li>
                            <li>网址：<a href="<?php echo $html['url']; ?>" title=""><?php echo $html['url']; ?></a></li>
                        </ul>
                    </figcaption>
                </figure>
            </section>
            <section class="mt10 clear">
                <h2>最新图片</h2>
            </section>
        </aside>
        <div class="fr w650">
            <section>
                <h2>帖子列表</h2>
                <a href="post.php" title="">发表帖子</a>
                <ul class="list">
                    <?php 
                        $htmllist = array();
                        while ( !!$rows = fetch_array_list($result,MYSQL_ASSOC)) {
                            $htmllist['id'] = $rows['bbs_id'];
                            $htmllist['title'] = $rows['bbs_title'];
                            $htmllist['type'] = $rows['bbs_type'];
                            $htmllist['readcount'] = $rows['bbs_readcount'];
                            $htmllist['commentcount'] = $rows['bbs_commentcount'];
                            $htmllist = html($htmllist);
                    ?>
                    <li><?php echo $htmllist['type']; ?><em>阅读数<strong>（<?php echo $htmllist['readcount']; ?>）</strong>评论数<strong>(<?php echo $htmllist['commentcount']; ?>)</strong></em><a href="article.php?id=<?php echo $htmllist['id']; ?>" title="<?php echo $htmllist['title']; ?>"><?php echo title($htmllist['title'],20); ?></a></li>
                    <?php } ?>
                </ul>
                    <?php 
                        free_result($result);
                        //pager参数：t表示文本式分页，n表数字分页
                        pager('t');
                    ?>
            </section>
        </div>
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
    <script src="js/blog.js"></script>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php'; 
    ?>
</body>
</html>
