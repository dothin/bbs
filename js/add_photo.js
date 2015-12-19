/* 
 * @Author: gaohuabin
 * @Date:   2015-12-19 13:09:45
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-19 15:18:11
 */
window.onload = function() {
    var oAddPhoto = document.getElementById('addphoto'),
        oClose = document.getElementById('close'),
        oAddPhotos = document.getElementById('addphotos'),
        oUpForm = oAddPhotos.getElementsByTagName('form')[0],
        oForm = document.getElementsByName('addphotodir')[0];
    oAddPhoto.onclick = function() {
        oAddPhotos.style.cssText = 'display:block;position:absolute;top:330px;left:520px;';
        oUpForm.action+='&dir='+oUpForm.dir.value+'&id='+oUpForm.id.value;
    }
    oClose.onclick = function() {
        oAddPhotos.style.display = 'none';
    }
    oForm.name.focus();
    //验证表单
     oForm.onsubmit = function() {
        if (oForm.name.value.length < 2 || oForm.name.value.length > 20) {
            alert('图片名称为2到20位');
            oForm.name.value = '';
            oForm.name.focus();
            return false;
        };
        if (oForm.url.value == '') {
            alert('图片地址不能为空');
            return false;
        };
        return true;
    }
}