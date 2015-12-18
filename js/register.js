/* 
 * @Author: gaohuabin
 * @Date:   2015-12-04 19:17:48
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-18 00:09:35
 */
window.onload = function() {
    var oSelectPhoto = document.getElementById('selectPhoto'),
        oPhotos = document.getElementById('photos'),
        oPhoto = document.getElementById('photo'),
        oClose = document.getElementById('close'),
        aImg = oPhotos.getElementsByTagName('img'),
        oForm = document.getElementsByName('register')[0],
        oRefreshCode = document.getElementById('refreshCode'),
        oCode = document.getElementById('code'),
        len = aImg.length;
    oForm.username.focus();
    if (oForm.dataset.reg == 0) {
        oForm.style.display = 'none';
        oForm.parentNode.innerHTML = '注册功能被管理员暂时取消了'
    };
    //头像
    for (var i = 0; i < len; i++) {
        aImg[i].src = aImg[i].alt = 'images/photo/photo (' + (i + 1) + ').jpg';
        aImg[i].onclick = function() {
            oPhoto.src = this.src;
            oForm.photo.value = this.alt;
            oPhotos.style.display = 'none';
        };
    };
    oSelectPhoto.onclick = function() {
        oPhotos.style.display = 'block';
    }
    oClose.onclick = function() {
        oPhotos.style.display = 'none';
    }
    //刷新验证码
    oRefreshCode.onclick = oCode.onclick = function() {
        oCode.src = 'code.php?t=' + Math.random();
    }
    //验证表单
    oForm.onsubmit = function() {
        if (oForm.username.value.length < 2 || oForm.username.value.length > 20) {
            alert('用户名长度为2到20位');
            oForm.username.value = '';
            oForm.username.focus();
            return false;
        };
        if (/[<>\'\"\\ ]/.test(oForm.username.value)) {
            alert('用户名不得包含敏感字符');
            oForm.username.value = '';
            oForm.username.focus();
            return false;
        };
        if (oForm.password.value.length < 6) {
            alert('密码最少6位');
            oForm.password.value = '';
            oForm.password.focus();
            return false;
        };
        if (oForm.aginePassword.value != oForm.password.value) {
            alert('密码和确认密码必须一致');
            oForm.aginePassword.value = '';
            oForm.aginePassword.focus();
            return false;
        };
        if (oForm.question.value.length < 2 || oForm.question.value.length > 20) {
            alert('密码提示长度为2到20位');
            oForm.question.value = '';
            oForm.question.focus();
            return false;
        };
        if (oForm.answer.value.length < 2 || oForm.answer.value.length > 20) {
            alert('密码回答长度为2到20位');
            oForm.answer.value = '';
            oForm.answer.focus();
            return false;
        };
        if (oForm.question.value == oForm.answer.value) {
            alert('密码提示和密码回答不能相同');
            oForm.answer.value = '';
            oForm.answer.focus();
            return false;
        };
        if (!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(oForm.email.value)) {
            alert('邮件格式不正确！');
            oForm.email.value = '';
            oForm.email.focus();
            return false;
        };
        if (oForm.qq.value != '') {
            if (!/^[1-9]{1}[0-9]{4,9}$/.test(oForm.qq.value)) {
                alert('QQ号码不正确！');
                oForm.qq.value = '';
                oForm.qq.focus();
                return false;
            };
        };
        if (oForm.url.value != 'http://') {
            if (!/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(oForm.url.value)) {
                alert('网址格式不正确');
                oForm.url.value = '';
                oForm.url.focus();
                return false;
            };
        };
        if (oForm.code.value.length != 4) {
            alert('验证码必须4位');
            oForm.code.value = '';
            oForm.code.focus();
            return false;
        };
        return true;
    }
}