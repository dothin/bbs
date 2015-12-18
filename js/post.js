/* 
 * @Author: gaohuabin
 * @Date:   2015-12-13 23:02:03
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-17 23:41:30
 */
(function() {
    var oRefreshCode = document.getElementById('refreshCode'),
        oCode = document.getElementById('code'),
        oForm = document.getElementsByName('post')[0],
        oUbb = document.getElementById('ubb'),
        aUbbImg = oUbb.getElementsByTagName('img'),
        oFont = document.getElementById('font'),
        oColor = document.getElementById('color'),
        oEmojis = document.getElementById('emojis'),
        oEmoji = document.getElementById('emoji'),
        oSelectEmoji = oEmoji.getElementsByTagName('a'),
        oClose = document.getElementById('close'),
        aImg = oEmojis.getElementsByTagName('img'),
        len = aImg.length,
        aCodeGroups = document.querySelectorAll(".code-groups"),
        bCode=true;
    //表情
    for (var i = 0; i < oSelectEmoji.length; i++) {
        (function(a) {
            oSelectEmoji[a].onclick = function() {
                oEmojis.style.display = 'block';
                oEmojis.style.top = this.offsetTop + 40 + 'px';
                oEmojis.style.left = this.offsetLeft + 'px';
                for (var i = 0; i < len; i++) {
                    aImg[i].src = aImg[i].alt = 'emoji/' + (a + 1) + '/' + (i + 1) + '.gif';
                    aImg[i].onclick = function() {
                        content('[img]' + this.alt + '[/img]');
                        oEmojis.style.display = 'none';
                    };
                };
            }
        })(i);
    };
    oClose.onclick = function() {
        oEmojis.style.display = 'none';
    }
    for (var i = 0; i < aCodeGroups.length; i++) {
        if (aCodeGroups[i].dataset.code == 0) {
            aCodeGroups[i].style.display = 'none';
            bCode=false;
        };
    };
    //刷新验证码
    oRefreshCode.onclick = oCode.onclick = function() {
        oCode.src = 'code.php?t=' + Math.random();
    }
    //验证表单
     oForm.onsubmit = function() {
        if (oForm.title.value.length < 2 || oForm.title.value.length > 40) {
            alert('帖子标题为2到40位');
            oForm.title.value = '';
            oForm.title.focus();
            return false;
        };
        if (oForm.content.value.length < 1 || oForm.content.value.length > 200) {
            alert('帖子内容长度不得小于10位');
            oForm.content.value = '';
            oForm.content.focus();
            return false;
        };
        if (bCode&&oForm.code.value.length != 4) {
            alert('验证码必须4位');
            oForm.code.value = '';
            oForm.code.focus();
            return false;
        };
        return true;
    }

    function content(str) {
        oForm.content.value += str;
    }
    aUbbImg[0].onclick = function(e) {
        var e = e || event;
        oFont.style.display = 'block';
        e.cancelBubble = true;
    }
    aUbbImg[7].onclick = function(e) {
        var e = e || event;
        oColor.style.display = 'block';
        e.cancelBubble = true;
    }
    document.onclick = function() {
        oFont.style.display = 'none';
        oColor.style.display = 'none';
    }
    aUbbImg[2].onclick = function() {
        content('[b][/b]');
    }
    aUbbImg[3].onclick = function() {
        content('[i][/i]');
    }
    aUbbImg[4].onclick = function() {
        content('[u][/u]');
    }
    aUbbImg[5].onclick = function() {
        content('[s][/s]');
    }
    aUbbImg[8].onclick = function() {
        var url = prompt('请输入网址', 'http://');
        if (url) {
            if (/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(url)) {
                content('[url]' + url + '[/url]');
            } else {
                alert('网址格式不正确');
            }
        };
    }
    aUbbImg[9].onclick = function() {
        var email = prompt('请输入电子邮件', '');
        if (email) {
            if (/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(email)) {
                content('[email]' + email + '[/email]');
            } else {
                alert('邮箱格式不正确');
            }
        };
    }
    aUbbImg[10].onclick = function() {
        var img = prompt('请输入图片地址', '');
        if (img) {
            content('[img]' + img + '[/img]');
        };
    }
    aUbbImg[11].onclick = function() {
        var flash = prompt('请输入视频Flash', 'http://');
        if (flash) {
            if (/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+/.test(flash)) {
                content('[flash]' + flash + '[/flash]');
            } else {
                alert('视频不合法');
            }
        };
    }
    aUbbImg[18].onclick = function() {
        oForm.content.rows += 2;
    }
    aUbbImg[19].onclick = function() {
        oForm.content.rows -= 2;
    }
})()

function font(size) {
    document.getElementsByName('post')[0].content.value += '[size=' + size + '][/size]';
}

function showColor(value) {
    document.getElementsByName('post')[0].content.value += '[color=' + value + '][/color]';
}