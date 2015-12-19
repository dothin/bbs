/* 
 * @Author: gaohuabin
 * @Date:   2015-12-08 13:17:16
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-18 19:32:30
 */
(function() {
    var oBlog = document.getElementsByTagName('section')[0],
        oMessage = document.getElementById('message'),
        oFriend = document.getElementById('friend'),
        oTips = document.getElementById('tips'),
        oRefreshCode = document.getElementById('refreshCode'),
        oCode = document.getElementById('code'),
        oForm = document.getElementById('mform'),
        aCodeGroups = document.querySelectorAll(".code-groups"),
        bCode=true;
    document.body.onclick = function(e) {
        var e = e || event;
        switch (e.target.name.toLowerCase()) {
            case 'message':
                oCode.src = 'code.php?t=' + Math.random();
                e.target.style.background = 'red';
                oMessage.style.left = e.target.parentNode.offsetLeft + 'px';
                oMessage.style.top = e.target.parentNode.offsetTop + 40 + 'px';
                oMessage.style.display = 'block';
                oMessage.style.transition = 'all .5s';
                if (oForm.flower) {
                    oForm.removeChild(oForm.flower);
                };
                oForm.action = 'blog.php?action=message';
                oTips.innerHTML = '发送消息给：';
                oForm.touser.value = oFriend.innerHTML = e.target.parentNode.parentNode.parentNode.getElementsByTagName('h3')[0].innerHTML;
                break;
            case 'friend':
                oCode.src = 'code.php?t=' + Math.random();
                e.target.style.background = 'red';
                oMessage.style.left = e.target.parentNode.offsetLeft + 'px';
                oMessage.style.top = e.target.parentNode.offsetTop + 40 + 'px';
                oMessage.style.display = 'block';
                if (oForm.flower) {
                    oForm.removeChild(oForm.flower);
                };
                oForm.action = 'blog.php?action=friend';
                oTips.innerHTML = '您正在添加好友：';
                oMessage.style.transition = 'all .5s';
                oForm.touser.value = oFriend.innerHTML = e.target.parentNode.parentNode.parentNode.getElementsByTagName('h3')[0].innerHTML;
                break;
            case 'flower':
                oCode.src = 'code.php?t=' + Math.random();
                e.target.style.background = 'red';
                oMessage.style.left = e.target.parentNode.offsetLeft + 'px';
                oMessage.style.top = e.target.parentNode.offsetTop + 40 + 'px';
                oMessage.style.display = 'block';
                if (!oForm.flower) {
                    var oSelect = document.createElement('select');
                    oSelect.name = 'flower';
                    for (var i = 0; i < 100; i++) {
                        var oOption = document.createElement('option');
                        oOption.innerHTML = i + 1 + '朵鲜花';
                        oSelect.appendChild(oOption);
                    };
                    //oForm.appendChild(oSelect);
                    oForm.insertBefore(oSelect, oForm.children[0]);
                    oSelect.style.cssText = 'width:100px;height:30px;margin-left:105px;';
                };
                oForm.action = 'blog.php?action=flower';
                oTips.innerHTML = '您正在送鲜花给：';
                oMessage.style.transition = 'all .5s';
                oForm.touser.value = oFriend.innerHTML = e.target.parentNode.parentNode.parentNode.getElementsByTagName('h3')[0].innerHTML;
                break;
            default:
                break;
        }
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
        if (oForm.content.value.length < 1 || oForm.content.value.length > 200) {
            alert('私信长度为1到200位');
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
})()