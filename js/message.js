/* 
 * @Author: gaohuabin
 * @Date:   2015-12-09 16:51:45
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2015-12-09 17:25:47
 */
window.onload = function() {
    var oForm = document.getElementById('delete');
    oForm.checkall.onclick = function() {
        for (var i = 0; i < oForm.elements.length; i++) {
            if (oForm.elements[i].name != 'checkall') {
                oForm.elements[i].checked = oForm.checkall.checked;
            };
        };
    }
    oForm.onsubmit = function() {
        if (confirm('确定删除？')) {
            return true;
        } else {
            return false;
        };
    }
}