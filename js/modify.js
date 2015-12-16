/* 
* @Author: gaohuabin
* @Date:   2015-12-07 15:00:18
* @Last Modified by:   gaohuabin
* @Last Modified time: 2015-12-07 16:15:17
*/

window.onload = function(){
    var oSelectPhoto = document.getElementById('selectPhoto'),
        oPhotos = document.getElementById('photos'),
        oPhoto = document.getElementById('photo'),
        oClose = document.getElementById('close'),
        aImg = oPhotos.getElementsByTagName('img'),
        oForm = document.getElementsByName('modify')[0],
        oRefreshCode = document.getElementById('refreshCode'),
        oCode = document.getElementById('code'),
        len = aImg.length;
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
        if (oForm.password.value != '') {
            if (oForm.password.value.length < 6) {
                alert('密码最少6位');
                oForm.password.value = '';
                oForm.password.focus();
                return false;
            };
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
                alert('网址不正确！');
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