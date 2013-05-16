var docEle = function() {
return document.getElementById(arguments[0]) || false;
}
function openNewDiv(_id) {
var m = "mask";
if (docEle(_id)) document.removeChild(docEle(_id));
if (docEle(m)) document.removeChild(docEle(m));
// 新激活图层
var newDiv = document.createElement("div");
newDiv.id = _id;
newDiv.style.position = "absolute";
newDiv.style.zIndex = "9999";
newDiv.style.width = "500px";
newDiv.style.height = "430px";
newDiv.style.top = "100px";
//newDiv.style.left = (parseInt(document.body.scrollWidth) -500) / 2 + "px"; // 屏幕居中
newDiv.style.left="100px";
newDiv.style.background = "#EFEFEF";
newDiv.style.border = "1px solid #860001";
newDiv.style.padding = "5px";
newDiv.innerHTML = "<br />Log:<br/>	<ul><li>2012年10月27日，到今天，这个应用已经做了一个星期了，大部分想要的功能已经实现了，包括对文件夹的加密。今天发布的这个版本是大部分程序都经过重写的版本，在服务器上试运行几天，如果没有问题，择日发布代码。</li><li>2012年10月26日，添加新建文件夹功能，并重新设计上传页面。晚，修正新建文件夹时，与原文件夹同名不报错的BUG；</li><li>2012年10月25日，处理部分细节问题，如设置当前目录中的主目录带有返回根目录的超链接，方便目录切换。</li><li>2012年10月24日晚，修复中文路径文件夹不能显示信息的bug。调整目录显示效果为：页面刷新，文件夹目录保持刷新前的状态。</li>	<li>2012年10月23日晚，完成目录与文件分类显示，并可以选择目录上传和下载内容。在下面的目录中选定目录，再上传文件，即可将文件传至相应目录中。</li>	<li>2012年10月23日，完成download.php页面的制作，保证IE>6，FF、Chrome等浏览器在下载文件后，关闭窗口时清除所下载的文件，对页面进行简单美化。</li>	<li>2012年10月22日午夜，发现用js写的关闭窗口删除临时文件的功能有漏洞，为顾及服务器安全，对下载文件类型做了限定，未对上传文件做限定。</li>	<li>2012年10月22日，为快盘应用增强下载功能。</li>	<li>2012年10月21日，我的快盘应用 CloudPen Uploader上线。实现基本上载和查询功能。</li>	</ul>	<br />";
document.body.appendChild(newDiv);
// mask图层
var newMask = document.createElement("div");
newMask.id = m;
newMask.style.position = "absolute";
newMask.style.zIndex = "1";
newMask.style.width = document.body.scrollWidth + "px";
newMask.style.height = document.body.scrollHeight + "px";
newMask.style.top = "0px";
newMask.style.left = "0px";
newMask.style.background = "#000";
newMask.style.filter = "alpha(opacity=40)";
newMask.style.opacity = "0.40";
document.body.appendChild(newMask);
// 关闭mask和新图层
var newA = document.createElement("a");
newA.href = "#";
newA.innerHTML = "点击关闭";
newA.onclick = function() {
document.body.removeChild(docEle(_id));
document.body.removeChild(docEle(m));
return false;
}
newDiv.appendChild(newA);
}


function diag()
{
    var str=prompt("请输入新建文件夹名","新建文件夹");
    if(str)
    {
        window.location="./creatfolder.php?foldername="+str;
    }
}

function upxian(){
	ux=document.getElementById("upload")
	ft=document.getElementById("filetj")
	if(ux.style.display=="none"){
	 ux.style.display=""; 
	 ft.value="隐藏提交框"
	 }
	 else
	     {ux.style.display="none";
	     ft.value="显示提交框"
	     }
	}

function setpasswd(){
	var str=prompt("注意：两级目录以内不允许设置密码.请输入密码","");
    if(str)
    {
        window.location="./function.php?spasswd="+str;
    }
	}
function getpasswd(){
	var str=prompt("请输入密码","");
    if(str)
    {
        window.location="./getpasswd.php?sendpass="+str;
    }
	
	}
