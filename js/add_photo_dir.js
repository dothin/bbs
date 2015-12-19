/* 
 * @Author: gaohuabin
 * @Date:   2015-12-18 23:49:18
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-19 12:57:49
 */
window.onload = function() {
    var oForm = document.getElementsByName('addphotodir')[0],
        oPass = document.getElementById('pass');
    for (var i = 0; i < oForm.type.length; i++) {
        oForm.type[i].onchange = function() {
            if (this.value == 1) {
                oPass.style.display = 'block';
            } else {
                oPass.style.display = 'none';
            };
        }
    };
    oForm.name.focus();
    //验证表单
     oForm.onsubmit = function() {
        if (oForm.name.value.length < 2 || oForm.name.value.length > 20) {
            alert('相册标题为2到20位');
            oForm.name.value = '';
            oForm.name.focus();
            return false;
        };
        if (oForm.type[1].checked==true&&oForm.password.value.length<6) {
            alert('相册密码不能小于6位');
            oForm.password.value = '';
            oForm.password.focus();
            return false;
        };
        return true;
    }
}