/* 
* @Author: gaohuabin
* @Date:   2015-12-06 15:23:54
* @Last Modified by:   gaohuabin
* @Last Modified time: 2015-12-18 00:02:42
*/
window.onload = function(){
    var oForm = document.getElementsByName('login')[0],
    oRefreshCode = document.getElementById('refreshCode'),
    oCode = document.getElementById('code'),
        aCodeGroups = document.querySelectorAll(".code-groups"),
        bCode=true;
    oForm.username.focus();
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
        
        if (bCode&&oForm.code.value.length != 4) {
            alert('验证码必须4位');
            oForm.code.value = '';
            oForm.code.focus();
            return false;
        };
        return true;
    }
}
