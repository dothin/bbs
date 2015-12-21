/* 
* @Author: gaohuabin
* @Date:   2015-12-21 13:41:51
* @Last Modified by:   gaohuabin
* @Last Modified time: 2015-12-21 13:52:10
*/

window.onload=function(){
    var oForm = document.getElementById('search'),
        oKeys = document.getElementById('keys'),
        aA=oKeys.getElementsByTagName('a');
        for (var i = 0; i < aA.length; i++) {
            aA[i].onclick = function(){
                this.href+='&text='+this.innerHTML;
            }
        };
}