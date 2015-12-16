<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-13 21:39:49
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-13 21:51:10
 */
$fp = @fopen('new.xml', 'w');
if (!$fp) {
    exit('系统错误，文件不存在');
}

flock($fp, LOCK_EX);
$string = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
fwrite($fp, $string, strlen($string));
$string = "<vip>\r\n";
fwrite($fp, $string, strlen($string));
$string = "\t<id>5</id>\r\n";
fwrite($fp, $string, strlen($string));
$string = "\t<username>石昊</username>\r\n";
fwrite($fp, $string, strlen($string));
$string = "\t<sex>男</sex>\r\n";
fwrite($fp, $string, strlen($string));
$string = "\t<photo>images/photo/photo (1).jpg</photo>\r\n";
fwrite($fp, $string, strlen($string));
$string = "\t<email>4343443@qq.com</email>\r\n";
fwrite($fp, $string, strlen($string));
$string = "\t<url>http://www.baidu.com</url>\r\n";
fwrite($fp, $string, strlen($string));
$string = "<vip>";
fwrite($fp, $string, strlen($string));
flock($fp, LOCK_UN);
fclose($fp);