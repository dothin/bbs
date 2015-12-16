<?php
/**
 * @Author: gaohuabin
 * @Date:   2015-12-14 20:42:00
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-14 20:42:28
 */
//防止恶意调用
if (!defined('IN_TG')) {
    exit('Access Defined!');
}
?>
<div id="ubb">
    <img src="images/fontsize.gif" title="字体大小" alt="字体大小" />
    <img src="images/space.gif" title="线条" alt="线条" />
    <img src="images/bold.gif" title="粗体" />
    <img src="images/italic.gif" title="斜体" />
    <img src="images/underline.gif" title="下划线" />
    <img src="images/strikethrough.gif" title="删除线" />
    <img src="images/space.gif" />
    <img src="images/color.gif" title="颜色" />
    <img src="images/url.gif" title="超链接" />
    <img src="images/email.gif" title="邮件" />
    <img src="images/image.gif" title="图片" />
    <img src="images/swf.gif" title="flash" />
    <img src="images/movie.gif" title="影片" />
    <img src="images/space.gif" />
    <img src="images/left.gif" title="左区域" />
    <img src="images/center.gif" title="中区域" />
    <img src="images/right.gif" title="右区域" />
    <img src="images/space.gif" />
    <img src="images/increase.gif" title="扩大输入区" />
    <img src="images/decrease.gif" title="缩小输入区" />
    <img src="images/help.gif" />
</div>
<div id="font">
    <strong onclick="font(10)">10px</strong>
    <strong onclick="font(12)">12px</strong>
    <strong onclick="font(14)">14px</strong>
    <strong onclick="font(16)">16px</strong>
    <strong onclick="font(18)">18px</strong>
    <strong onclick="font(20)">20px</strong>
    <strong onclick="font(22)">22px</strong>
    <strong onclick="font(24)">24px</strong>
</div>
<div id="color">
    <strong title="黑色" style="background:#000" onclick="showColor('#000')"></strong>
    <strong title="褐色" style="background:#930" onclick="showColor('#930')"></strong>
    <strong title="橄榄树" style="background:#330" onclick="showColor('#330')"></strong>
    <strong title="深绿" style="background:#030" onclick="showColor('#030')"></strong>
    <strong title="深青" style="background:#036" onclick="showColor('#036')"></strong>
    <strong title="深蓝" style="background:#000080" onclick="showColor('#000080')"></strong>
    <strong title="靓蓝" style="background:#339" onclick="showColor('#339')"></strong>
    <strong title="灰色-80%" style="background:#333" onclick="showColor('#333')"></strong>
    <strong title="深红" style="background:#800000" onclick="showColor('#800000')"></strong>
    <strong title="橙红" style="background:#f60" onclick="showColor('#f60')"></strong>
    <strong title="深黄" style="background:#808000" onclick="showColor('#000')"></strong>
    <strong title="深绿" style="background:#008000" onclick="showColor('#808000')"></strong>
    <strong title="绿色" style="background:#008080" onclick="showColor('#008080')"></strong>
    <strong title="蓝色" style="background:#00f" onclick="showColor('#00f')"></strong>
    <strong title="蓝灰" style="background:#669" onclick="showColor('#669')"></strong>
    <strong title="灰色-50%" style="background:#808080" onclick="showColor('#808080')"></strong>
    <strong title="红色" style="background:#f00" onclick="showColor('#f00')"></strong>
    <strong title="浅橙" style="background:#f90" onclick="showColor('#f90')"></strong>
    <strong title="酸橙" style="background:#9c0" onclick="showColor('#9c0')"></strong>
    <strong title="海绿" style="background:#396" onclick="showColor('#396')"></strong>
    <strong title="水绿色" style="background:#3cc" onclick="showColor('#3cc')"></strong>
    <strong title="浅蓝" style="background:#36f" onclick="showColor('#36f')"></strong>
    <strong title="紫罗兰" style="background:#800080" onclick="showColor('#800080')"></strong>
    <strong title="灰色-40%" style="background:#999" onclick="showColor('#999')"></strong>
    <strong title="粉红" style="background:#f0f" onclick="showColor('#f0f')"></strong>
    <strong title="金色" style="background:#fc0" onclick="showColor('#fc0')"></strong>
    <strong title="黄色" style="background:#ff0" onclick="showColor('#ff0')"></strong>
    <strong title="鲜绿" style="background:#0f0" onclick="showColor('#0f0')"></strong>
    <strong title="青绿" style="background:#0ff" onclick="showColor('#0ff')"></strong>
    <strong title="天蓝" style="background:#0cf" onclick="showColor('#0cf')"></strong>
    <strong title="梅红" style="background:#936" onclick="showColor('#936')"></strong>
    <strong title="灰度-20%" style="background:#c0c0c0" onclick="showColor('#c0c0c0')"></strong>
    <strong title="玫瑰红" style="background:#f90" onclick="showColor('#f90')"></strong>
    <strong title="茶色" style="background:#fc9" onclick="showColor('#fc9')"></strong>
    <strong title="浅黄" style="background:#ff9" onclick="showColor('#ff9')"></strong>
    <strong title="浅绿" style="background:#cfc" onclick="showColor('#cfc')"></strong>
    <strong title="浅青绿" style="background:#cff" onclick="showColor('#cff')"></strong>
    <strong title="浅蓝" style="background:#9cf" onclick="showColor('#9cf')"></strong>
    <strong title="淡紫" style="background:#c9f" onclick="showColor('#c9f')"></strong>
    <strong title="白色" style="background:#fff" ></strong>
    <em><input type="text" name="t" value="#" /></em>
</div>