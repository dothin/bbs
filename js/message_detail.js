/* 
* @Author: gaohuabin
* @Date:   2015-12-09 11:39:10
* @Last Modified by:   gaohuabin
* @Last Modified time: 2015-12-09 17:44:13
*/
window.onload  = function(){
    var oBack = document.getElementById('back'),
        oDelete = document.getElementById('delete');

        oBack.onclick = function(){
            history.back();
        }
        oDelete.onclick = function(){
            if (confirm('确定删除？')) {
                window.location.href = 'message_detail.php?action=delete&id='+this.name;
            };
        }
}