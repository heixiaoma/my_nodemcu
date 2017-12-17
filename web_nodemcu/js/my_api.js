
function sendget(ye)
{
	/*
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null){
		alert('您的浏览器不支持AJAX！');
		return;
	}

	var url="../api.php?type=month&ye="+ye;
	xmlHttp.open("GET",url,true);
	xmlHttp.onreadystatechange=favorOK;//发送事件后，收到信息了调用函数
	xmlHttp.send();
*/
	window.location.href="../yzw/api.php?type=month&ye="+ye;


}