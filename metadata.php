<head>
	<title>文件列表页</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.21" />
    <link href="img/css.css" rel="stylesheet" type="text/css"> 
    <script type="text/javascript" src="./img/mask.js"></script>
</head>

<body>
<form name="form1" method="post" action="" enctype="multipart/form-data" >
	<div id="upload" style= "display:none; "><input type="file" name="uploadfile" >	<input type="submit" value="上传文件" ></div>
	</form>
	

<?php
header("Content-Type: text/html; charset=UTF-8") ;
session_start (); 
require_once('conn.php');
require_once('function.php');

if($_FILES['uploadfile']['name']!=""){
	move_uploaded_file($_FILES['uploadfile']['tmp_name'], "upload/".$_FILES['uploadfile']['name']);
	echo "<a href='metadata.php'>这是测试服务器，对文件大小做了限制，请重新选择较小文件上传。点击返回</a>";
	$upload = $kp->api ( 'fileops/upload_locate' );
    $lsnf=$_SESSION['nf'];
    if (false !== $upload) {
    // file to upload
        $params = array (
            'root' => 'app_folder',
            'overwrite' => 'true',
            'path' => $lsnf.'/'.$_FILES['uploadfile']['name'] 
    );
    $filename = dirname ( __FILE__ ) . "/upload/".$_FILES['uploadfile']['name'];
    $ret = $kp->api ( sprintf ( '%s/1/fileops/upload_file', rtrim ( $upload ['url'], '/' ) ), '', $params, 'POST', $filename );
    if (false === $ret) {
        $ret = $kp->getError ();
        }
    $_SESSION['ff']="ok";
    
    unlink( $filename);
    header ( 'Location:metadata.php' );
    } else {
    $ret = $kp->getError ();
     }
//return $ret;
 }

if($_GET['folder'] && $_SESSION['ff']!="ok"){
	$_SESSION['access']=0;
	if($_GET['folder']=='up'){
		
		$str=$_SESSION['nf'];
		$len=strrpos($str,"/");
		$nowfolder=substr($str,0,$len);
		$_SESSION['nf']=$nowfolder;
		}else if($_GET['folder']=='me'){
			$_SESSION['nf']="";
			}else{
	$myfolder=UrlDecode($_GET['folder']);
	$nowfolder=$_SESSION['nf'];
	$nowfolder=$nowfolder.'/'.$myfolder;
	$_SESSION['nf']=$nowfolder;}
	} else{
		$_SESSION['ff']="no";
		$nowfolder=$_SESSION['nf'];
		}
 
$root_path = 'app_folder'.UrlEncode($nowfolder); //应用拥有整个快盘的权限，否则可以使用ap_folder
//echo "当前目录：".$root_path;
$ret = $kp->api ( 'metadata', $root_path, $params );
if (false === $ret) {
    $ret = $kp->getError ();
}
//echo $ret['name'];

//print_r($ret);
function my_compare($a, $b) {
if ($a['name'] < $b['name'])
   return -1;
else if ($a['name'] == $b['name'])
   return 0;
else
   return 1;
}
//排序
yanzheng1();
//del_str_line('./passwd/15562566',2);
if($_SESSION['yespass']!=='no') {
echo "<div><input type='button' value='新建文件夹' onClick='diag()'>";
echo "<input type='button' id='filetj' value='显示提交框' onClick='upxian()' />"; 
	$countf= substr_count($nowfolder,'/');
	if($countf > 1){
	echo "<input type='button' id='sp' value='设置文件夹密码' onClick='setpasswd()' /> </div>";
	     }
	else{
		echo "<input type='button' id='sp' value='两层以内文件夹不可设置密码' /> </div>";
	} 
}
		
usort($ret['files'], 'my_compare'); 
echo "<br />";
echo "当前目录：<a href='metadata.php?folder=me'>主目录</a>".urldecode($nowfolder) ."<br />";
echo "快盘中已有的文件(已按拼音字母排序)： <br />";
echo "================================= <br />";
//验证是否有密码

if(yanzheng()  or $_SESSION['access']==1){
echo "<UL>";
    if( $root_path != 'app_folder') echo "<li class='w'><a href='metadata.php?folder=up' >..向上一层</a><br />";
    for($i=0;$i<sizeof($ret['files']) ;$i++)
        if($ret['files'][$i]['type']=="folder")
           echo "<li class='w'><a href='metadata.php?folder=". UrlEncode($ret['files'][$i]['name'])." '  >".$ret['files'][$i]['name']."</a><br />";

    for($i=0;$i<sizeof($ret['files']) ;$i++)
        if($ret['files'][$i]['type']=="file")
           echo "<li class='f'><a href='download.php?fn=".$ret['files'][$i]['name']." ' target='_blank' >".$ret['files'][$i]['name']."</a><br />";
echo "</UL>";}

?>


</body>

</html>
