<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-03 22:35:02
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-18 12:33:17
 */
/**
 * [admin_login 管理员登录权限]
 * @return [type] [description]
 */
function admin_login(){
    //管理员才能登录进来
    if (!isset($_COOKIE['username']) || !isset($_SESSION['admin'])) {
        alert('权限不够');   
    }
}
/**
 * [runtime 用来执行耗时]
 * @access public 
 * @return [float] [返回出浮点型数]
 */
function runtime(){
    $mtime = explode(' ', microtime());
    return $mtime[1]+$mtime[0];
}
/**
 * [limit_time 设置间隔时间]
 * @param  [type] $str      [要间隔时间的内容]
 * @param  [type] $now_time [现在时间]
 * @param  [type] $pre_time [之前时间]
 * @param  [type] $second   [间隔秒数]
 * @return [type]           [description]
 */
function limit_time($str,$now_time,$pre_time,$second){
    if ($now_time-$pre_time<$second) {
       aLert($str.'间隔时间不能小于'.$second);
    }
}
/**
 * [alert 弹窗提示]
 * @access public
 * @param  [string] $str [提示信息]
 * @return [void]      [description]
 */
function alert($str){
    echo "<script>alert('$str');history.back();</script>";
    exit();
}
/**
 * [location 弹出提示，并跳转到指定的url]
 * @param  [type] $str [description]
 * @param  [type] $url [description]
 * @return [type]      [description]
 */
function location($str,$url){
    if (!empty($str)) {
        echo "<script>alert('$str');window.location.href='$url';</script>";
        exit();
    }else{
        header('Location:'.$url);
    }
}
function ubb($str){
    $str = nl2br($str);
    $str = preg_replace('/\[size=(.*)\](.*)\[\/size\]/U', '<span style="font-size:\1px;">\2</span>', $str);
    $str = preg_replace('/\[b\](.*)\[\/b\]/U', '<strong>\1</strong>', $str);
    $str = preg_replace('/\[i\](.*)\[\/i\]/U', '<em style="font-style:italic;">\1</em>', $str);
    $str = preg_replace('/\[u\](.*)\[\/u\]/U', '<span style="text-decoration:underline;">\1</span>', $str);
    $str = preg_replace('/\[s\](.*)\[\/s\]/U', '<em style="text-decoration:line-through;">\1</em>', $str);
    $str = preg_replace('/\[color=(.*)\](.*)\[\/color\]/U', '<span style="color:\1">\2</span>', $str);
    $str = preg_replace('/\[url\](.*)\[\/url\]/U', '<a href="\1" target="_black">\1</a>', $str);
    $str = preg_replace('/\[email\](.*)\[\/email\]/U', '<a href="mailto:\1">\1</a>', $str);
    $str = preg_replace('/\[img\](.*)\[\/img\]/U', '<img src="\1" alt="图片">', $str);
    $str = preg_replace('/\[flash\](.*)\[\/flash\]/U', '<embed src="\1" type="" style="width:600px;height:400px;" >', $str);
    return $str;
}
/**
 * [title 标题截取函数]
 * @param  [type] $str [description]
 * @param  [type] $strlen [截取长度]
 * @return [type]      [description]
 */
function title($str,$strlen){
    if (mb_strlen($str,'utf-8')>$strlen) {
        $str = mb_substr($str, 0,$strlen,'utf-8').'...';
    }
    return $str;
}
/**
 * [html 将数据库提取的数据的html格式去除掉,如果是数组就按照数组方式过滤，如果是字符串，就按照字符串方式过滤]
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function html($str){
    if (is_array($str)) {
        foreach ($str as $key => $value) {
            $str[$key] = html($value);
        }
    }else{
        $str = htmlspecialchars($str);
    }
    return $str;
}
/**
 * [uniqid_check 判断唯一标识符是否异常]
 * @param  [type] $mysql_uniqid  [description]
 * @param  [type] $cookie_uniqid [description]
 * @return [type]                [description]
 */
function uniqid_check($mysql_uniqid,$cookie_uniqid){
    if ($mysql_uniqid != $cookie_uniqid) {
        alert('唯一标识符异常！请重新检验后再提交');
    }
}
/**
 * [set_xml 注册时生成的xml文件，用于显示新增会员用]
 * @param [type] $xmlfile [文件名]
 * @param [type] $clean   [参数]
 */
function set_xml($xmlfile,$clean){
    $fp = @fopen($xmlfile, 'w');
    /*if (!$fp) {
        exit('系统错误，文件不存在');
    }*/

    flock($fp, LOCK_EX);
    $string = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
    fwrite($fp, $string, strlen($string));
    $string = "<vip>\r\n";
    fwrite($fp, $string, strlen($string));
    $string = "\t<id>{$clean['id']}</id>\r\n";
    fwrite($fp, $string, strlen($string));
    $string = "\t<username>{$clean['username']}</username>\r\n";
    fwrite($fp, $string, strlen($string));
    $string = "\t<sex>{$clean['sex']}</sex>\r\n";
    fwrite($fp, $string, strlen($string));
    $string = "\t<photo>{$clean['photo']}</photo>\r\n";
    fwrite($fp, $string, strlen($string));
    $string = "\t<email>{$clean['email']}</email>\r\n";
    fwrite($fp, $string, strlen($string));
    $string = "\t<url>{$clean['url']}</url>\r\n";
    fwrite($fp, $string, strlen($string));
    $string = "</vip>\r\n";
    fwrite($fp, $string, strlen($string));
    flock($fp, LOCK_UN);
    fclose($fp);
}
/**
 * [get_xml 读取xml]
 * @param  [type] $xmlfile [description]
 * @return [type]          [description]
 */
function get_xml($xmlfile){
    $html=array();
    if (file_exists($xmlfile)) {
        $xml=file_get_contents('new.xml');
        preg_match_all('/<vip>(.*)<\/vip>/s', $xml, $dom);
        foreach ($dom[1] as $value) {
            preg_match_all('/<id>(.*)<\/id>/s', $value, $id);
            preg_match_all('/<username>(.*)<\/username>/s', $value, $username);
            preg_match_all('/<sex>(.*)<\/sex>/s', $value, $sex);
            preg_match_all('/<photo>(.*)<\/photo>/s', $value, $photo);
            preg_match_all('/<email>(.*)<\/email>/s', $value, $email);
            preg_match_all('/<url>(.*)<\/url>/s', $value, $url);
            $html['id']=$id[1][0];
            $html['username']=$username[1][0];
            $html['sex']=$sex[1][0];
            $html['photo']=$photo[1][0];
            $html['email']=$email[1][0];
            $html['url']=$url[1][0];
        }
    }else{
        echo "文件不存在";
    }
    return $html;
}
/**
 * [move_cookies 清除cookie和session]
 * @return [type] [description]
 */
function move_cookies(){
    setcookie('username','',time()-1);
    setcookie('uniqid','',time()-1);
    session_destroy();
    location(null,'index.php');
}
/**
 * [login_state 判断登陆状态]
 * @return [type] [description]
 */
function login_state(){
    if (isset($_COOKIE['username'])) {
        location('登录状态下无法进行本操作','index.php');
    }
}
/**
 * [sha1_uniqid 返回转义后的用sha1加了密的唯一标识符]
 * @return [string] [description]
 */
function sha1_uniqid(){
    return mysql_real_escape_string(sha1(uniqid(rand(),true)));
}
/**
 * [check_code 验证验证码]
 * @param  [string] $first_code [description]
 * @param  [string] $end_code   [description]
 * @return [void]             [description]
 */
function check_code($first_code,$end_code){
    if ($first_code != $end_code) {
        alert('验证码错误！');
    }
}
/**
 * [code 用来生成验证码]
 * @access public
 * @return [void] [产生一个验证码]
 * @param int $width 验证码长度
 * @param int $height 验证码高度
 * @param int $rnd_num 验证码位数
 */
function code($width = 80, $height = 35, $rnd_num = 4){
    $msg = '';
    //创建16进制随机数，四位验证码
    for($i = 0;$i<$rnd_num;$i++){
        $msg .= dechex(mt_rand(0,15)); 
    }
    //将验证码保存在session里面
    $_SESSION['code'] = $msg;

    //创建图像舞台
    $img = imagecreatetruecolor($width, $height);

    //颜色
    $white = imagecolorallocate($img, 255, 255, 255);
    $black = imagecolorallocate($img, 0, 0, 0);
    $rnd_color = imagecolorallocate($img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)) ;
    //设置填充
    imagefill($img, 0, 0, $white);
    //边框
    imagerectangle($img, 0, 0, $width-1, $height-1, $rnd_color);

    //干扰线条
    for($i=0;$i<6;$i++){
        $rnd_color = imagecolorallocate($img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)) ;
        imageline($img, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $rnd_color);
    }
    //干扰雪花
    for($i=0;$i<100;$i++){
        $rnd_color = imagecolorallocate($img, mt_rand(200,255), mt_rand(200,255), mt_rand(200,255)) ;
        imagestring($img, 1, mt_rand(1,$width-10), mt_rand(1,$height-10), '*', $rnd_color);
    }
    //写入验证码到舞台
    for($i=0;$i<strlen($_SESSION['code']);$i++){
        $rnd_color = imagecolorallocate($img, mt_rand(0,100), mt_rand(0,150), mt_rand(0,200)) ;
        imagestring($img, mt_rand(5,15), $i*$width/$rnd_num+mt_rand(1,10), mt_rand(1,$height/2), $_SESSION['code'][$i], $rnd_color);
    }
    //输出图像
    header('Content-Type:image/png');
    imagepng($img);
    //销毁
    imagedestroy($img);
}
/**
 * [pager_param 分页参数设置]
 * @param  [type] $sql  [获取总共有多少条数据]
 * @param  [int] $size [设置每页多少条数据]
 * @return [type]       [description]
 */
function pager_param($sql,$size){
    //让里面的所有参数取出来，使外部可以访问
    //$page_size:每页多少条数据
    //$page_num:从第几条开始查询
    //$page_total:总共多少页
    //$sum_num:总共有多少条数据
    //$page:当前页数
    global $page_size,$page_num,$page_total,$sum_num,$page;
    //分页模块
    //如果页数为空或者为负值或者不是数字，就把页码设为1，若为小数，则取整
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if (empty($page) || $page <= 0 || !is_numeric($page)) {
            $page = 1;
        }else{
            $page = intval($page);
        }
    }else{
        $page = 1;
    }
    //每页查询多少条数据
    $page_size = $size;

    //计算总共多少页，首先要得到总共有多少条数据
    $sum_num = num_rows(query($sql));
    //计算总页数，若为空，则总页数设置为1
    if ($sum_num == 0) {
        $page_total =1;
    }else{
        $page_total = ceil($sum_num/$page_size);
    }
    //如果输入页数大于总页数，则让页数等于最大页数
    if ($page>$page_total) {
        $page= $page_total;
    }
    //从第几条数据开始查询
    $page_num=($page-1)*$page_size;
}

/**
 * [pager 输出分页]
 * @param  [type] $type [分页类型]
 * @return [type]       [description]
 */
function pager($type){
    //将$page_total,$page,$sum_num;做成全局变量，不然访问不到
    //$id:传入的id
    global $page_total,$page,$sum_num,$id;
    if ($type == 'n') {
        echo '<div id="pager">';
        echo '<ul class="clear inline">';
            
        for($i=0;$i<$page_total;$i++){
            if ($page == $i+1) {
            echo '<li class="p10 ddd"><a href="'.$_SERVER['SCRIPT_NAME'].'?'.$id.'page='.($i+1).'">'.($i+1).'</a></li>';
            }else{
            echo '<li class="p10"><a href="'.$_SERVER['SCRIPT_NAME'].'?'.$id.'page='.($i+1).'">'.($i+1).'</a></li>';
            }
        } 
        echo '</ul>';
        echo '</div>';
    }elseif($type == 't'){
        echo '<div class="pager">';
        echo '<ul class="clear inline">';    
        echo '<li class="p10">'.$page.'/'.$page_total.'</li>';
        echo '<li class="p10">共有<strong>'.$sum_num.'</strong>条数据 |</li>';
        if ($page ==1) {
            echo '<li class="p10">首页 |</li><li class="p10">上一页 |</li>';
        }else{
            echo '<li class="p10"><a href="'.$_SERVER['SCRIPT_NAME'].'?'.$id.'">首页 |</a></li><li class="p10"><a href="'.$_SERVER['SCRIPT_NAME'].'?'.$id.'page='.($page-1).'" title="">上一页 |</a></li>';
        }
        if ($page == $page_total) {
             echo '<li class="p10">下一页 |</li><li class="p10">尾页</li>';
         }else{
            echo '<li class="p10"><a href="'.$_SERVER['SCRIPT_NAME'].'?'.$id.'page='.($page+1).'" title="">下一页 |</a></li><li class="p10"><a href="'.$_SERVER['SCRIPT_NAME'].'?'.$id.'page='.$page_total.'" title="">尾页</a></li>';
         } 
        echo '</ul>';    
        echo '</div>';
    }else{
        pager('t');
    }
}
?>